<?php

return [
    "100.100.100" => "Request contains no
        credit card, bank account number or bank name", 
   "100.100.101" => "Invalid credit card, bank account number or bank name", 
   "100.100.104" => "Invalid unique id / root unique id", 
   "100.100.200" => "Request contains no month", 
   "100.100.201" => "Invalid month", 
   "100.100.300" => "Request contains no year", 
   "100.100.301" => "Invalid year", 
   "100.100.303" => "Card expired", 
   "100.100.304" => "Card not yet valid", 
   "100.100.305" => "Invalid expiration date format", 
   "100.100.400" => "Request contains no cc/bank account holder", 
   "100.100.401" => "Bank account holder too short or too long", 
   "100.100.402" => "Bank account holder not valid", 
   "100.100.500" => "Invalid card type", 
   "100.100.501" => "Invalid card type", 
   "100.100.600" => "Empty CVV for VISA,MASTER, AMEX not allowed", 
   "100.100.601" => "Invalid card type", 
   "100.100.650" => "Empty credit card issue number for maestro not allowed", 
   "100.100.651" => "Invalid credit card issue number", 
   "100.100.700" => "Invalid card type", 
   "100.100.701" => "Suspecting fraud, this card may not be processed", 
   "100.200.100" => "Bank account has invalid bank code, 
    name account number combination", 
   "100.200.104" => "Bank account has invalid account number format", 
   "100.200.200" => "Bank account needs to be registered and confirmed first.
    Country is mandate based.", 
   "100.210.101" => "Virtual account contains no or invalid Id", 
   "100.210.102" => "Virtual account contains no or invalid card type", 
   "100.211.101" => "User account contains no or invalid Id", 
   "100.211.102" => "User account contains no or invalid Cart type", 
   "100.211.103" => "No password defined for user account", 
   "100.211.104" => "Password does not meet safety requirements
     (needs 8 digits at least and must contain letters and numbers)", 
   "100.211.105" => "Wallet id has to be a valid email address", 
   "100.211.106" => "Voucher ids have 32 digits always", 
   "100.212.101" => "Wallet account registration must not have an initial balance", 
   "100.212.102" => "Wallet account contains no or invalid card type", 
   "100.212.103" => "Wallet account payment transaction needs to
    reference a registration", 
   "100.550.300" => "request contains no amount or too low amount", 
   "100.550.301" => "amount too large", 
   "100.550.303" => "amount format invalid (only two decimals allowed).", 
   "100.550.310" => "amount exceeds limit for the registered account.", 
   "100.550.311" => "exceeding account balance", 
   "100.550.312" => "Amount is outside allowed ticket size boundaries", 
   "100.550.400" => "request contains no currency", 
   "100.550.401" => "invalid currency", 
   "100.550.601" => "risk amount too large", 
   "100.550.603" => "risk amount format invalid (only two decimals allowed)", 
   "100.550.605" => "risk amount is smaller than amount 
    (it must be equal or bigger then amount)", 
   "100.550.701" => "amounts not matched", 
   "100.550.702" => "currencies not matched", 
   "100.380.101" => "transaction contains no risk management part", 
   "100.380.201" => "no risk management process type specified", 
   "100.380.305" => "no frontend information provided for asynchronous transaction", 
   "100.380.306" => "no authentication data provided 
    in risk management transaction", 
   "000.100.200" => "Reason not Specified", 
   "000.100.201" => "Account or Bank Details Incorrect", 
   "000.100.202" => "Account Closed", 
   "000.100.203" => "Insufficient Funds", 
   "000.100.204" => "Mandate not Valid", 
   "000.100.205" => "Mandate Cancelled", 
   "000.100.206" => "Revocation or Dispute", 
   "000.100.207" => "Cancellation in Clearing Network", 
   "000.100.208" => "Account Blocked", 
   "000.100.209" => "Account does not exist", 
   "000.100.210" => "Invalid Amount", 
   "000.100.211" => "Transaction succeeded
     (amount of transaction is smaller then amount of pre-authorization)", 
   "000.100.212" => "Transaction succeeded 
    (amount of transaction is greater then amount of pre-authorization)", 
   "000.100.220" => "Fraudulent Transaction", 
   "000.100.221" => "Merchandise Not Received", 
   "000.100.222" => "Transaction Not Recognized By Cardholder", 
   "000.100.223" => "Service Not Rendered", 
   "000.100.224" => "Duplicate Processing", 
   "000.100.225" => "Credit Not Processed", 
   "000.100.226" => "Cannot be settled", 
   "000.100.227" => "Configuration Issue", 
   "000.100.228" => "Temporary Communication Error - Retry", 
   "000.100.229" => "Incorrect Instructions", 
   "000.100.230" => "Unauthorised Charge", 
   "000.100.231" => "Late Representment", 
   "000.100.232" => "Liability Shift", 
   "000.100.233" => "Authorization-Related Chargeback", 
   "000.100.234" => "Non receipt of merchandise", 
   "000.100.299" => "Unspecified (Technical)", 
   "500.100.201" => "Channel/Merchant is disabled (no processing possible)", 
   "500.100.202" => "Channel/Merchant is new (no processing possible yet)", 
   "500.100.203" => "Channel/Merchant is closed (no processing possible)", 
   "500.100.301" => "Merchant-Connector is disabled (no processing possible)", 
   "500.100.302" => "Merchant-Connector is new (no processing possible yet)", 
   "500.100.303" => "Merchant-Connector is closed (no processing possible)", 
   "500.100.304" => "Merchant-Connector is disabled
     at gateway (no processing possible)", 
   "500.100.401" => "Connector is unavailable (no processing possible)", 
   "500.100.402" => "Connector is new (no processing possible yet)", 
   "500.100.403" => "Connector is unavailable (no processing possible)", 
   "500.200.101" => "No target account configured for DD transaction", 
   "600.200.100" => "invalid Payment Method", 
   "600.200.200" => "Unsupported Payment Method", 
   "600.200.201" => "Channel/Merchant not configured for this payment method", 
   "600.200.202" => "Channel/Merchant not configured for this payment type", 
   "600.200.300" => "invalid Payment Type", 
   "600.200.310" => "invalid Payment Type for given Payment Method", 
   "600.200.400" => "Unsupported Payment Type", 
   "600.200.500" => "Invalid payment data. You are not configured 
    for this currency or sub type (country or brand)", 
   "600.200.501" => "Invalid payment data for Recurring transaction. 
    Merchant or transaction data has wrong recurring configuration.", 
   "600.200.600" => "invalid payment code (type or method)", 
   "600.200.700" => "invalid payment mode 
    (you are not configured for the requested transaction mode)", 
   "600.200.800" => "invalid brand for given payment method and payment mode
     (you are not configured for the requested transaction mode)", 
   "600.200.810" => "invalid return code provided", 
   "600.300.101" => "Merchant key not found", 
   "600.300.200" => "merchant source IP address not whitelisted", 
   "600.300.210" => "merchant notificationUrl not whitelisted", 
   "600.300.211" => "shopperResultUrl not whitelisted", 
   "800.121.100" => "Channel not configured for given source type.
     Please contact your account manager.", 
   "800.121.200" => "Secure Query is not enabled for this entity.
     Please contact your account manager.", 
   "100.150.100" => "request contains no Account data and no registration id", 
   "100.150.101" => "invalid format for specified registration id 
    (must be uuid format)", 
   "100.150.200" => "registration does not exist", 
   "100.150.201" => "registration is not confirmed yet", 
   "100.150.202" => "registration is already deregistered", 
   "100.150.203" => "registration is not valid, probably initially rejected", 
   "100.150.204" => "account registration reference pointed to no 
    registration transaction", 
   "100.150.205" => "referenced registration does not contain an account", 
   "100.150.300" => "payment only allowed with valid initial registration", 
   "100.350.100" => "referenced session is REJECTED (no action possible).", 
   "100.350.101" => "referenced session is CLOSED (no action possible)", 
   "100.350.200" => "undefined session state", 
   "100.350.201" => "referencing a registration through reference 
    id is not applicable for this payment type", 
   "100.350.301" => "confirmation (CF) must be registered (RG) first", 
   "100.350.302" => "session already confirmed (CF)", 
   "100.350.303" => "cannot deregister (DR) unregistered account and/or customer", 
   "100.350.310" => "cannot confirm (CF) session via XML", 
   "100.350.311" => "cannot confirm (CF) on a registration passthrough channel", 
   "100.350.312" => "cannot do passthrough on non-internal connector", 
   "100.350.313" => "registration of this type has to provide confirmation url", 
   "100.350.314" => "customer could not be notified of pin to confirm registration 
    (channel)", 
   "100.350.315" => "customer could not be notified of pin to confirm registration 
    (sending failed)", 
   "100.350.400" => "no or invalid PIN (email/SMS/MicroDeposit authentication)
     entered", 
   "100.350.500" => "unable to obtain personal (virtual) account - most likely 
    no more accounts available", 
   "100.350.601" => "registration is not allowed to reference another transaction", 
   "100.350.602" => "Registration is not allowed for recurring payment migration", 
   "100.250.100" => "job contains no execution information", 
   "100.250.105" => "invalid or missing action type", 
   "100.250.106" => "invalid or missing duration unit", 
   "100.250.107" => "invalid or missing notice unit", 
   "100.250.110" => "missing job execution", 
   "100.250.111" => "missing job expression", 
   "100.250.120" => "invalid execution parameters, combination does
     not conform to standard", 
   "100.250.121" => "invalid execution parameters, hour must be between 0 and 23", 
   "100.250.122" => "invalid execution parameters, minute and seconds must
     be between 0 and 59", 
   "100.250.123" => "invalid execution parameters, Day of month must
     be between 1 and 31", 
   "100.250.124" => "invalid execution parameters, month must
     be between 1 and 12", 
   "100.250.125" => "invalid execution parameters, Day of week must
     be between 1 and 7", 
   "100.250.250" => "Job tag missing", 
   "100.360.201" => "unknown schedule type", 
   "100.360.300" => "cannot schedule(SD) unscheduled job", 
   "100.360.303" => "cannot deschedule(DS) unscheduled job", 
   "100.360.400" => "schedule module not configured for LIVE transaction mode", 
   "700.100.100" => "reference id not existing", 
   "700.100.200" => "non matching reference amount", 
   "700.100.300" => "invalid amount (probably too large)", 
   "700.100.400" => "referenced payment method does not match with
     requested payment method", 
   "700.100.500" => "referenced payment currency does not match with 
    requested payment currency", 
   "700.100.600" => "referenced mode does not match with requested payment mode", 
   "700.100.700" => "referenced transaction is of inappropriate type", 
   "700.100.701" => "referenced a DB transaction without explicitly 
    providing an account. Not allowed to used referenced account.", 
   "700.100.710" => "cross-linkage of two transaction-trees", 
   "700.300.100" => "referenced tx can not be refunded, captured or reversed
     (invalid type)", 
   "700.300.200" => "referenced tx was rejected", 
   "700.300.300" => "referenced tx can not be refunded, captured or reversed 
    (already refunded, captured or reversed)", 
   "700.300.400" => "referenced tx can not be captured (cut off time reached)", 
   "700.300.500" => "chargeback error (multiple chargebacks)", 
   "700.300.600" => "referenced tx can not be refunded or reversed 
    (was chargebacked)", 
   "700.300.700" => "referenced tx can not be reversed
     (reversal not possible anymore)", 
   "700.300.800" => "referenced tx can not be voided", 
   "700.400.000" => "serious workflow error (call support)", 
   "700.400.100" => "cannot capture 
    (PA value exceeded, PA reverted or invalid workflow?)  ", 
   "700.400.101" => "cannot capture (Not supported by authorization system)", 
   "700.400.200" => "cannot refund (refund volume exceeded or 
    tx reversed or invalid workflow?)", 
   "700.400.300" => "cannot reverse (already refunded|reversed, 
    invalid workflow or amount exceeded)", 
   "700.400.400" => "cannot chargeback (already chargebacked or invalid workflow?)", 
   "700.400.402" => "chargeback can only be generated internally
     by the payment system", 
   "700.400.410" => "cannot reversal chargeback 
    (chargeback is already reversaled or invalid workflow?)", 
   "700.400.411" => "cannot reverse chargeback or invalid workflow
     (second chargeback)", 
   "700.400.420" => "cannot reversal chargeback
     (no chargeback existing or invalid workflow?)", 
   "700.400.510" => "capture needs at least one successful transaction of type
     (PA)", 
   "700.400.520" => "refund needs at least one successful transaction of type
     (CP or DB or RB or RC)", 
   "700.400.530" => "reversal needs at least one successful transaction of type
     (CP or DB or RB or PA)", 
   "700.400.540" => "reconceile needs at least one successful transaction of type
     (CP or DB or RB)", 
   "700.400.550" => "chargeback needs at least one successful transaction of type
     (CP or DB or RB)", 
   "700.400.560" => "receipt needs at least one successful transaction of type
     (PA or CP or DB or RB)", 
   "700.400.561" => "receipt on a registration needs a successfull registration
     in state OPEN", 
   "700.400.562" => "receipts are configured to be generated only internally by
     the payment system", 
   "700.400.565" => "finalize needs at least one successful transaction of type
    (PA or DB)", 
   "700.400.570" => "cannot reference a waiting/pending transaction", 
   "700.400.580" => "cannot find transaction", 
   "700.400.590" => "installment needs at least one successful transaction of type
     (DB or PA)", 
   "700.400.600" => "finalize needs at least one successful transaction of type
     (IN, DB, PA or CD)", 
   "700.400.700" => "initial and referencing channel-ids do not match", 
   "700.450.001" => "cannot transfer money from one account to the same account", 
   "700.500.001" => "referenced session contains too many transactions", 
   "700.500.002" => "capture or preauthorization appears too late in
     referenced session", 
   "700.500.003" => "test accounts not allowed in production", 
   "700.500.004" => "cannot refer a transaction which contains deleted 
    customer information", 
   "100.300.101" => "invalid test mode (please use LIVE or INTEGRATOR_TEST
     or CONNECTOR_TEST)", 
   "100.300.200" => "transaction id too long", 
   "100.300.300" => "invalid reference id", 
   "100.300.400" => "missing or invalid channel id", 
   "100.300.401" => "missing or invalid sender id", 
   "100.300.402" => "missing or invalid version", 
   "100.300.501" => "invalid response id", 
   "100.300.600" => "invalid or missing user login", 
   "100.300.601" => "invalid or missing user pwd", 
   "100.300.700" => "invalid relevance", 
   "100.300.701" => "invalid relevance for given payment type", 
   "100.370.100" => "transaction declined", 
   "100.370.101" => "responseUrl not set in Transaction/Frontend", 
   "100.370.102" => "malformed responseUrl in Transaction/Frontend", 
   "100.370.110" => "transaction must be executed for German address", 
   "100.370.111" => "system error( possible incorrect/missing input data)", 
   "100.370.121" => "no or unknown ECI Type defined in Authentication", 
   "100.370.122" => "parameter with null key provided in 3DSecure Authentication", 
   "100.370.123" => "no or unknown verification type defined in
     3DSecure Authentication", 
   "100.370.124" => "unknown parameter key in 3DSecure Authentication", 
   "100.370.125" => "Invalid 3DSecure Verification_ID. Must have Base64 
    encoding a Length of 28 digits", 
   "100.370.131" => "no or unknown authentication type defined in
     Transaction/Authentication@type", 
   "100.370.132" => "no result indicator defined
     Transaction/Authentication/resultIndicator", 
   "100.500.101" => "payment method invalid", 
   "100.500.201" => "payment type invalid", 
   "100.500.301" => "invalid due date", 
   "100.500.302" => "invalid mandate date of signature", 
   "100.500.303" => "invalid mandate id", 
   "100.500.304" => "invalid mandate external id", 
   "100.600.500" => "usage field too long", 
   "100.900.500" => "invalid recurrence mode", 
   "200.100.101" => "invalid Request Message. No valid XML. XML must be
     url-encoded! maybe it contains a not encoded ampersand or something similar.", 
   "200.100.102" => "invalid Request. XML load missing 
    (XML string must be sent within parameter load)", 
   "200.100.103" => "invalid Request Message. The request
     contains structural errors", 
   "200.100.150" => "transaction of multirequest not processed
     because of subsequent problems", 
   "200.100.151" => "multi-request is allowed with a maximum 
    of 10 transactions only", 
   "200.100.199" => "Wrong Web Interface / URL used. 
    Please check out the Tech Quick Start Doc Chapter 3.", 
   "200.100.201" => "invalid Request/Transaction tag 
    (not present or [partially] empty)", 
   "200.100.300" => "invalid Request/Transaction/Payment tag
     (no or invalid code specified)", 
   "200.100.301" => "invalid Request/Transaction/Payment tag 
    (not present or [partially] empty)", 
   "200.100.302" => "invalid Request/Transaction/Payment/Presentation tag
     (not present or [partially] empty)", 
   "200.100.401" => "invalid Request/Transaction/Account tag 
    (not present or [partially] empty)", 
   "200.100.402" => "invalid Request/Transaction/Account(Customer, Relevance) tag 
    (one of Account/Customer/Relevance must be present)", 
   "200.100.403" => "invalid Request/Transaction/Analysis tag
     (Criterions must have a name and value)", 
   "200.100.404" => "invalid Request/Transaction/Account (must not be present)", 
   "200.100.501" => "invalid or missing customer", 
   "200.100.502" => "invalid Request/Transaction/Customer/Name tag
     (not present or [partially] empty)", 
   "200.100.503" => "invalid Request/Transaction/Customer/Contact tag 
    (not present or [partially] empty)", 
   "200.100.504" => "invalid Request/Transaction/Customer/Address tag 
    (not present or [partially] empty)", 
   "200.100.601" => "invalid Request/Transaction/(ApplePay|GooglePay) tag 
    (not present or [partially] empty)", 
   "200.100.602" => "invalid Request/Transaction/(ApplePay|GooglePay)/
    PaymentToken tag (not present or [partially] empty)", 
   "200.100.603" => "invalid Request/Transaction/(ApplePay|GooglePay)/
    PaymentToken tag (decryption error)", 
   "200.200.106" => "duplicate transaction. Please verify that the UUID is unique", 
   "200.300.403" => "Invalid HTTP method", 
   "200.300.404" => "invalid or missing parameter", 
   "200.300.405" => "Duplicate entity", 
   "200.300.406" => "Entity not found", 
   "200.300.407" => "Entity not specific enough", 
   "800.900.100" => "sender authorization failed", 
   "800.900.101" => "invalid email address (probably invalid syntax)", 
   "800.900.200" => "invalid phone number
     (has to start with a digit or a +, at least 7 and max 25 chars long)", 
   "800.900.201" => "unknown channel", 
   "800.900.300" => "invalid authentication information", 
   "800.900.301" => "user authorization failed,
     user has no sufficient rights to process transaction", 
   "800.900.302" => "Authorization failed", 
   "800.900.303" => "No token created", 
   "800.900.399" => "Secure Registration Problem", 
   "800.900.401" => "Invalid IP number", 
   "800.900.450" => "Invalid birthdate", 
   "100.800.100" => "request contains no street", 
   "100.800.101" => "The combination of street1 and street2
     must not exceed 201 characters.", 
   "100.800.102" => "The combination of street1 and street2
     must not contain only numbers.", 
   "100.800.200" => "request contains no zip", 
   "100.800.201" => "zip too long", 
   "100.800.202" => "invalid zip", 
   "100.800.300" => "request contains no city", 
   "100.800.301" => "city too long", 
   "100.800.302" => "invalid city", 
   "100.800.400" => "invalid state/country combination", 
   "100.800.401" => "state too long", 
   "100.800.500" => "request contains no country", 
   "100.800.501" => "invalid country", 
   "100.700.100" => "customer.surname may not be null", 
   "100.700.101" => "customer.surname length must be between 0 and 50", 
   "100.700.200" => "customer.givenName may not be null", 
   "100.700.201" => "customer.givenName length must be between 0 and 50", 
   "100.700.300" => "invalid salutation", 
   "100.700.400" => "invalid title", 
   "100.700.500" => "company name too long", 
   "100.700.800" => 'identity contains no or invalid "paper"', 
   "100.700.801" => "identity contains no or invalid identification value", 
   "100.700.802" => "identification value too long", 
   "100.700.810" => "specify at least one identity", 
   "100.900.100" => "request contains no email address", 
   "100.900.101" => "invalid email address (probably invalid syntax)", 
   "100.900.105" => "email address too long (max 50 chars)", 
   "100.900.200" => "invalid phone number
     (has to start with a digit or a +, at least 7 and max 25 chars long)", 
   "100.900.300" => "invalid mobile phone number 
    (has to start with a digit or a +, at least 7 and max 25 chars long)", 
   "100.900.301" => "mobile phone number mandatory", 
   "100.900.400" => "request contains no ip number", 
   "100.900.401" => "invalid ip number", 
   "100.900.450" => "invalid birthdate", 
   "800.100.156" => "transaction declined (format error)" 
];
