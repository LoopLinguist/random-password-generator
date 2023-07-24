# Random Password Generator for Laravel Applications

This Laravel package serves to generate random passwords tailored to your specific requirements. It offers a range of options, including passwords with symbols, numbers only, characters only, mixed lowercase and uppercase letters, non-symbol passwords, or combinations of digits and characters. You can customize the password generation process to suit your application's security needs effectively.

### It provides the following features:

*  Including symbols: Users can choose to include symbols in the generated password.
*  Only numbers: Users can opt for passwords consisting of numbers only.
*  Only characters: Users can generate passwords with alphabetic characters only.
*  Non-symbol passwords: Users can choose to generate passwords without any symbols.
*  Digits and characters only: This option allows generating passwords with digits and alphabetic characters only.

Once the parameters are provided, the function creates a random password that satisfies the specified requirements.
It ensures that the generated password meets the security standards for Laravel applications.


### Example usage 

#### Default Method:

```php

use LoopLinguist\RandomPasswordGenerator\GeneratePassword;

    //  ... 

   $generatePassword = new GeneratePassword();
   $generatedPassword = $generatePassword->generatePassword();

```
**Example Output** 

```bash
q5%tZp_AYQ!Q
```

#### To generate passwords consisting of only digits and a mix of lowercase and uppercase letters:


```php

use LoopLinguist\RandomPasswordGenerator\GeneratePassword;

    //  ... 

   $generatePassword = new GeneratePassword();
   $generatePassword
        ->removeSymbols(false);
   $generatedPassword = $generatePassword->generatePassword();

```

**Example Output** 

```bash
Vm5bdQaPDFMd
```

###### Available methods

Here, you have the flexibility to exclude characters of digits, uppercase letters, numbers, or symbols.

```  
removeUppercase();     // To exclude UpperCase, this method.
removeLowercase();     // To exclude LowerCase,this method.
removeNumbers();       // To exclude Numbers,this method.
removeSymbols();       // To exclude Symbols,this method. - You can set your required symbols in the config file.
removeAvoidSimilar();  // To Include Similar characters (`iIl1Oo0`),this method.
``` 

###### Available methods - Requirements Based Strict

Here, you have the flexibility to specify the number of characters for password generation, or you can enforce a requirement that the password must contain at least 'n' characters of digits, uppercase letters, numbers, or symbols.

``` 
setLength(12);          // Pass the desired number to set password length.
upperCaseRequired();    // Pass the desired number to set Fixed UpperCase length - empty will be considered as a length 1.
lowerCaseRequired();    // Pass the desired number to set Fixed LowerCase length - empty will be considered as a length 1.
numbersRequired();      // Pass the desired number to set Fixed Number length - empty will be considered as a length 1.
symbolsRequired();      // Pass the desired number to set Fixed Symbol length - empty will be considered as a length 1.

```

Publish the config file with:

```bash
php artisan vendor:publish --tag=random-password-generator-config    
```