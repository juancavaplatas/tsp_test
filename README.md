# SUMMARY
This code implements a brute force solution for the Travelling Salesman Problem. The algorithm resolves a maximum of (n! / 2) cities permutations where n is the number of cities of the list.

You can configure the algorithm execution time before start it. Just define of the $maxTime variable using another value in seconds.

We are able to apply some general configuration parameters including them through the files in the config folder.

The src code is distributed in the next folders
- Controllers: business logic.
- Models: Repositories, entities definitions and their factories.
- Utils: some useful mathematical tools.

# ACTIONS
The project includes the composer.phar file. First of all, download the project dev dependencies with the next command:
- php composer.phar update

The code can be tested (PHPCPD, PHPMD and PHPUnit) with the next composer custom command:
- php composer.phar test

The final solution script can be executed with the command (max 15 minutes of execution):
- php solve.php
