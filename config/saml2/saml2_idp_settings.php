<?php

// If you choose to use ENV vars to define these values, give this IdP its own env var names
// so you can define different values for each IdP, all starting with 'SAML2_'.$this_idp_env_id
$this_idp_env_id = 'SAML2';

return $settings = [

    /*****
     * One Login Settings
     */

    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => true, //@todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => env('APP_DEBUG', false),

    // Service Provider Data that we are deploying
    'sp' => [

        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => env($this_idp_env_id.'_SP_x509', ''),
        'privateKey' => env($this_idp_env_id.'_SP_PRIVATEKEY', ''),

        // Identifier (URI) of the SP entity.
        // Leave blank to use the '{idpName}_metadata' route, e.g. 'test_metadata'.
        'entityId' => env($this_idp_env_id.'_SP_ENTITYID', ''),

        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => [
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-POST binding.
            // Leave blank to use the '{idpName}_acs' route, e.g. 'test_acs'
            'url' => '',
        ],
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        // Remove this part to not include any URL Location in the metadata.
        'singleLogoutService' => [
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-Redirect binding.
            // Leave blank to use the '{idpName}_sls' route, e.g. 'test_sls'
            'url' => '',
        ],
    ],

    // Identity Provider Data that we want connect with our SP
    'idp' => [
        // Identifier of the IdP entity  (must be a URI)
        'entityId' => env($this_idp_env_id.'_IDP_ENTITYID'),
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => [
            // URL Target of the IdP where the SP will send the Authentication Request Message,
            // using HTTP-Redirect binding.
            'url' => env($this_idp_env_id.'_IDP_SSO_URL', ''),
        ],
        // SLO endpoint info of the IdP.
        'singleLogoutService' => [
            // URL Location of the IdP where the SP will send the SLO Request,
            // using HTTP-Redirect binding.
            'url' => env($this_idp_env_id.'_IDP_SL_URL', ''),
        ],

        'x509cert' => '',
        /**
         * Enable Multi-Cert signing/encryption
         * In some scenarios the IdP uses different certificates for
         * signing/encryption, or is under key rollover phase and
         * more than one certificate is published on IdP metadata.
         * In order to handle that the toolkit offers that parameter.
         */
        'x509certMulti'=> [
            'signing'=> [
                0 => env($this_idp_env_id.'_IDP_X509_SIGNING_0', ''),
                1 => env($this_idp_env_id.'_IDP_X509_SIGNING_1', ''),
                2 => env($this_idp_env_id.'_IDP_X509_SIGNING_2', ''),
                3 => env($this_idp_env_id.'_IDP_X509_SIGNING_3', ''),
                4 => env($this_idp_env_id.'_IDP_X509_SIGNING_4', ''),
            ],
        ],
    ],

    /***
     *
     *  OneLogin advanced settings
     *
     *
     */
    // Security settings
    'security' => [

        /** signatures and encryptions offered */

        // Indicates that the nameID of the <samlp:logoutRequest> sent by this SP
        // will be encrypted.
        'nameIdEncrypted' => false,

        // Indicates whether the <samlp:AuthnRequest> messages sent by this SP
        // will be signed.              [The Metadata of the SP will offer this info]
        'authnRequestsSigned' => false,

        // Indicates whether the <samlp:logoutRequest> messages sent by this SP
        // will be signed.
        'logoutRequestSigned' => false,

        // Indicates whether the <samlp:logoutResponse> messages sent by this SP
        // will be signed.
        'logoutResponseSigned' => false,

        /* Sign the Metadata
        False || True (use sp certs) || [
            keyFileName => 'metadata.key',
            certFileName => 'metadata.crt'
        ]
        */
        'signMetadata' => false,

        /** signatures and encryptions required **/

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => true,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => true,
    ],

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => [
        'technical' => [
            'givenName' => 'name',
            'emailAddress' => env('SAML2_SUPPORT_ADDRESS', ''),
        ],
        'support' => [
            'givenName' => 'Support',
            'emailAddress' => env('SAML2_SUPPORT_ADDRESS', ''),
        ],
    ],

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => [
        'en-GB' => [
            'name' => 'Name',
            'displayname' => env('APP_NAME', ''),
            'url' => env('APP_URL', ''),
        ],
    ],
];
