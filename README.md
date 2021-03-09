
## Installation

Use the `muzmatch.sql` file in `database` DIR to create the DB. I have attached an image to explain the relationship between the tables.


Configure the DB in: `app\settings.php`


Run this following command from the main directory in order to finish the installation:
```
composer install
```


Run the local server with:
```
composer start
```


Run the PhpUnit test with: (Test run over dummy data present in the file muzmatch.sql)
```
composer test
```

***


