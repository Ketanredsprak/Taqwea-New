<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;

/**
 * AwsSecretManagerService
 */
class AwsSecretManagerService
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->configVariables = config('secret-manager.configVariables');
        $this->region = config('secret-manager.aws.region');
        $this->secretName = config('secret-manager.aws.secretName');
        $this->profileName = config('secret-manager.aws.profileName');
        $this->credentialsPath = config('secret-manager.aws.credentialsPath');
        $this->sharedConfig = config('secret-manager.aws.sharedConfig');

        $this->isSecretManagerLoaded = config("isSecretManagerLoaded", false);
        $this->checkSecretManagerApi 
            = config('secret-manager.checkSecretManagerApi', false);
    }

    /**
     * Method loadSecrets
     * 
     * @return void
     */
    public function loadSecrets()
    {

        //Only run this if the environment is enabled
        if (!$this->isSecretManagerLoaded || $this->checkSecretManagerApi) {
            $provider = CredentialProvider::memoize(
                CredentialProvider::ini($this->profileName, $this->credentialsPath)
            );
            
            // Get env variables from aws secret manager
            $client = new SecretsManagerClient(
                [
                    'version' => 'latest',
                    'region' => $this->region,
                    'use_aws_shared_config_files' => $this->sharedConfig,
                    'credentials' => $provider
                ]
            );
           
            try {
                $result = $client->getSecretValue(
                    [
                        'SecretId' => $this->secretName,
                    ]
                );
            } catch (AwsException $e) {
                $error = $e->getAwsErrorCode();
                if ($error == 'DecryptionFailureException') {
                    throw $e;
                }
                if ($error == 'InternalServiceErrorException') {
                    throw $e;
                }
                if ($error == 'InvalidParameterException') {
                    throw $e;
                }
                if ($error == 'InvalidRequestException') {
                    throw $e;
                }
                if ($error == 'ResourceNotFoundException') {
                    throw $e;
                }
            }

            
            if (isset($result['SecretString'])) {
                $variable = json_decode($result['SecretString']);
            } else {
                $variable = json_decode(base64_decode($result['SecretBinary']));
            }

            if (!empty($variable)) {
                foreach ($variable as $key => $value) {
                    putenv($key."=".$value);
                }

                //Process variables in config that need updating
                $this->updateConfigs();
            }
        }
    }

    /**
     * Method updateConfigs
     * 
     * @return void 
     */
    protected function updateConfigs()
    {
        // Update config variables from env
        foreach ($this->configVariables as $variable => $configPath) {
            if (!empty(getenv($variable))) {
                config([$configPath => getenv($variable)]);

                if ($variable == "AWS_ACCESS_KEY_ID") {
                    config(['filesystems.disks.s3private.key' => getenv($variable)]);
                }

                if ($variable == "AWS_SECRET_ACCESS_KEY") {
                    config(
                        ['filesystems.disks.s3private.secret' => getenv($variable)]
                    );
                }
            }
        }
        config(["isSecretManagerLoaded" => true]);
    }
}
