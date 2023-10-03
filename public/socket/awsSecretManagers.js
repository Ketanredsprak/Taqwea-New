
const AWS = require("aws-sdk");
const dotenv = require("dotenv");
module.exports = () => {
	//configure AWS SDK
	var aws_region  = process.env.AWS_DEFAULT_REGION;
	var aws_profile = process.env.AWS_PROFILE_NAME;

	AWS.CredentialProviderChain.defaultProviders = [
		function () { return new AWS.EnvironmentCredentials('AWS'); },
		function () { return new AWS.EnvironmentCredentials('AMAZON'); },
		function () { return new AWS.SharedIniFileCredentials({profile: aws_profile ? aws_profile : 'default' }); },
		function () { return new AWS.EC2MetadataCredentials(); }
	];

	var chain = new AWS.CredentialProviderChain();
	chain.resolve((err, cred)=>{
		AWS.config.credentials = cred;
	});

	AWS.config.update({ region: aws_region });
	
	const client = new AWS.SecretsManager(
			{ 
				apiVersion:'latest',
				region : aws_region
			}
		);
	const SecretId = process.env.AWS_SECRET_NAME;;
	return new Promise((resolve, reject) => {
		//retrieving secrets from secrets manager
		client.getSecretValue({ SecretId:SecretId }, (err, data) => {
			if (err) {
				reject(err);
			} else {
				//parsing the fetched data into JSON
				const secretsJSON = JSON.parse(data.SecretString);

				// creating a string to store write to .env file
				let secretsString = "";
				Object.keys(secretsJSON).forEach((key) => {
					process.env[key]= secretsJSON[key];
				});
				dotenv.config();
				resolve(secretsString);
			}
		});
	});
};