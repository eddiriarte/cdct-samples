@contract
Feature: As user I am able to authenticate with my email and password.

  Scenario: Authentication with existent consumer via consumer-service
    When I login with "bob@php-usergroup.berlin" and "S3creTPa5$w0Rd"
    Then my credentials are validated by consumer-service 
    Then the response status code is 200
    And the response content contains consumer details

  Scenario: Authentication with unexistent consumer via consumer-service
    When I login with "dr-who@php-usergroup.london" and "S3creTPa5$w0Rd"
    Then my credentials are validated by consumer-service 
    Then the response status code is 401
    And the response content contains error "Unable to authenticate consumer with given credentials."

  Scenario: Authentication with wrong password via consumer-service
    When I login with "bob@php-usergroup.berlin" and "wr0NG-Pa5$w0Rd"
    Then my credentials are validated by consumer-service 
    Then the response status code is 401
    And the response content contains error "Unable to authenticate consumer with given credentials."
