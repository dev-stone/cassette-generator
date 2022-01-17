# Cassettes generator to generate [PHP-VCR](https://php-vcr.github.io/) cassettes

## Installation
```shell
composer require --dev arlauskas/cassette-generator
```

## Usage
```shell
bin/vcg vcg_config.yaml
```

## Config example
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
