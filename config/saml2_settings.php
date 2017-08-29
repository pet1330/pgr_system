<?php

//This is variable is an example - Just make sure that the urls in the 'idp' config are ok.
$idp_host = 'https://adfs.lincoln.ac.uk:443';

return $settings = array(

    /**
     * If 'useRoutes' is set to true, the package defines five new routes:
     *
     *    Method | URI                      | Name
     *    -------|--------------------------|------------------
     *    POST   | {routesPrefix}/acs       | saml_acs
     *    GET    | {routesPrefix}/login     | saml_login
     *    GET    | {routesPrefix}/logout    | saml_logout
     *    GET    | {routesPrefix}/metadata  | saml_metadata
     *    GET    | {routesPrefix}/sls       | saml_sls
     */
    'useRoutes' => true,

    'routesPrefix' => '/saml2',

    /**
     * which middleware group to use for the saml routes
     * Laravel 5.2 will need a group which includes StartSession
     */
    'routesMiddleware' => ['web'],

    /**
     * Indicates how the parameters will be
     * retrieved from the sls request for signature validation
     */
    'retrieveParametersFromServer' => false,

    /**
     * Where to redirect after logout
     */
    'logoutRoute' => '/you-are-logged-out',

    /**
     * Where to redirect after login if no other option was provided
     */
    'loginRoute' => '/loggedin',


    /**
     * Where to redirect after login if no other option was provided
     */
    'errorRoute' => '/error',




    /*****
     * One Login Settings
     */



    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => false, //@todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => true, //@todo: make this depend on laravel config

    // Service Provider Data that we are deploying
    'sp' => array(

        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        //'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => '',
        'privateKey' => '',

        // Identifier (URI) of the SP entity.
        // Leave blank to use the 'saml_metadata' route.
        'entityId' => '',

        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-POST binding.
            // Leave blank to use the 'saml_acs' route
            'url' => '',
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-Redirect binding.
            // Leave blank to use the 'saml_sls' route
            'url' => '',
        ),
    ),

    // Identity Provider Data that we want connect with our SP
    'idp' => array(
        // Identifier of the IdP entity  (must be a URI)

        'entityId' => $idp_host . '/federationmetadata/2007-06/federationmetadata.xml',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the SP will send the Authentication Request Message,
            // using HTTP-Redirect binding.

            'url' => $idp_host . '/adfs/ls',
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where the SP will send the SLO Request,
            // using HTTP-Redirect binding.

            'url' => $idp_host . '/adfs/ls?wa=wsignout1.0',
        ),
        // Public x509 certificate of the IdP

        'x509cert' => 'MIIC4DCCAcigAwIBAgIQfZ4RS/LKyJ5Ax128/65MDDANBgkqhkiG9w0BAQsFADAsMSowKAYDVQQDEyFBREZTIFNpZ25pbmcgLSBhZGZzLmxpbmNvbG4uYWMudWswHhcNMTcwNDEyMDI0MDUzWhcNMjAwNDExMDI0MDUzWjAsMSowKAYDVQQDEyFBREZTIFNpZ25pbmcgLSBhZGZzLmxpbmNvbG4uYWMudWswggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCkGih3kEXpFJ8aey1SBdB9TEJ5KbPaBuZ4JzD/zbY2g42wMPnmlchawouzHwCJynG8zGFt20xnuhsCdTE4Tqt9YGnWoIF9VU93KOT7AfTBkubUvWlgXBdpp07Q892RIojrykxz9T88dd2KY3kBuy7+tKWNkXQl5W6dPI4gTE3mk0EPTO68wlunEUbEsDNc7r6fLkNlIitR4blwdWeHVYoBBihHnDZlT2yv/EcKNTcHjN8c6PSIvi6dhjsPDfhBQdAYSX5jO75aEXhJ4+zUg8u7Pbwb9eTNMQ0mty28+iEcnAq6T5ppYYUnKNUgjZT2JTb6F6RxTV1LgxOa2GVB5MnPAgMBAAEwDQYJKoZIhvcNAQELBQADggEBADs4fx9fdoDO20iAHvAwYrvRaIhd65g3c4W1jQwCeA2/+DYBvfOO9t9VhzmQlUvA+X0x1rqh9GoamGfOVAzOg3ikQbOlCxRXitYNQHwCQAZ8PjVCOpQKeWbzo2bO2MwQUYdXOTrSGhc83fZEovT4kpmKC3RiOvVCTe1geqpHAoAFHa/ZDKSw8uG1zv+X4M7vWsOJJ5tx/l716f1YYqEUtsfLlDKue+OWtdiyKGO/JzYypEh7xQBdXc+GKaUd1bwpsl01f8ZMIKF4340V10FCNyr/9CH7KQBYKDRZ788imJbMuc8BKh6pkun/ETGPDr25/uMEXNSL6H4Jemfq0nChC+M=',
        /*
         *  Instead of use the whole x509cert you can use a fingerprint
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it)
         */
        // 'certFingerprint' => '',
    ),



    /***
     *
     *  OneLogin advanced settings
     *
     *
     */
    // Security settings
    'security' => array(

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
         False || True (use sp certs) || array (
                                                    keyFileName => 'metadata.key',
                                                    certFileName => 'metadata.crt'
                                                )
        */
        'signMetadata' => false,


        /** signatures and encryptions required **/

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => false,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => true,
    ),

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => array(
        'technical' => array(
            'givenName' => 'name',
            'emailAddress' => 'pet1330@gmail.com'
        ),
        'support' => array(
            'givenName' => 'Support',
            'emailAddress' => 'pet1330@gmail.com'
        ),
    ),

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => array(
        'en-GB' => array(
            'name' => 'Name',
            'displayname' => 'PGR System',
            'url' => 'http://saml.lcas.group'
        ),
    ),

/* Interoperable SAML 2.0 Web Browser SSO Profile [saml2int]   http://saml2int.org/profile/current

   'authnRequestsSigned' => false,    // SP SHOULD NOT sign the <samlp:AuthnRequest>,
                                      // MUST NOT assume that the IdP validates the sign
   'wantAssertionsSigned' => true,
   'wantAssertionsEncrypted' => true, // MUST be enabled if SSL/HTTPs is disabled
   'wantNameIdEncrypted' => false,
*/

);
