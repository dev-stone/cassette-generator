# Cassettes generator to generate [PHP-VCR](https://php-vcr.github.io/) cassettes

## Installation
```shell
composer require --dev arlauskas/cassette-generator
```

## Usage
```shell
vendor/bin/vcg vcg_config.yaml
```

## Configuration example

### vcg_config.yaml
```yaml
record-defaults:
    request:
        method: POST
        url: "'http://127.0.0.1:8080/soap'"
        headers:
            Host: "'127.0.0.1:8080'"
            Content-Type: "'text/xml; charset=utf-8;'"
            SOAPAction: "'http://tempuri.org/'"
    response:
        status:
            http_version: "'1.1'"
            code: "'200'"
            message: OK
        headers:
            Cache-Control: private
            Content-Length: "'196'"
            Content-Type: "'text/xml; charset=utf-8'"
            Server: Microsoft-IIS/8.0
            X-AspNet-Version: 4.0.30319
            X-Powered-By: ASP.NET
            Date: "'Wed, 10 Feb 2021 07:35:56 GMT'"
cassettes-settings:
    -
        name: 'integration_tests'
        input-dir: './assets/'
        output-dir: './output/'
        cassettes:
            -
                output-file: 'login_process.yaml'
                records:
                    -
                        request: 'find_user_request.xml'
                        response: 'find_user_response.xml'
                        append:
                            'request|headers|SOAPAction': 'IAppService/FindUser'
                        rewrite:
                            'response|headers|Date':
                    -
                        request: 'user_login_request.xml'
                        response: 'user_login_response.xml'
                        append:
                            'request|headers|SOAPAction': 'IAppService/Login'
                        rewrite:
                            'response|headers|Date':
            -
                output-file: 'registration_process.yaml'
                records:
                    -
                        request: 'check_code_request.xml'
                        response: 'check_code_response.xml'
                        append:
                            'request|headers|SOAPAction': 'IAppService/CheckCode'
                        rewrite:
                            'response|headers|Date':
                    -
                        request: 'pass_code_request.xml'
                        response: 'pass_code_response.xml'
                        append:
                            'request|headers|SOAPAction': 'IAppService/PassCode'
                        rewrite:
                            'response|headers|Date':

```

### find_user_request.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
    <SOAP-ENV:Body>
        <ns1:FindUser>
            <ns1:User>test@example.com</ns1:User>
        </ns1:FindUser>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

### find_user_response.xml

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
    <SOAP-ENV:Body>
        <ns1:FindUserResponse>
            <ns1:FindUserResult>true</ns1:FindUserResult>
        </ns1:FindUserResponse>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```


## Config reference

### record-defaults
In every record will be provided default information.

### cassettes-settings
Here you will provide configuration how your files structure will look like.
Cassette will be written into files and every will have one or more records.
`record-defaults` data will be provided into every record.

`request` and `response` will try to look files from `input-dir` from cassettes holder.

`append` will add data provided by `record-defaults` settings.

`rewrite` will replace data provided by `record-defaults` settings.

Every cassette will be written to directory `output-dir` and named by `output-file`.
