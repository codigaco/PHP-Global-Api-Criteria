# Global-Api-Criteria

## Installation
Use the package manager [composer](https://getcomposer.org/download/) to install Global Api Criteria.

```bash
composer require quiquegilb/global-api-criteria
```

## Usage
Simple usage.
```php
$criteria = Criteria::create()
     ->withFilter(FilterGroup::deserialize('(name like computer or name like pc) and price > 500 and price <= 1000'))
     ->withOrder(OrderGroup::deserialize('+price, stock desc'))
     ->withPaginate(Paginate::create(0, 5));
```

## Custom and security usage
View [ProductCriteriaExample](https://github.com/QuiqueGilB/PHP-Global-Api-Criteria/blob/main/example/ProductContext/ProductModule/Domain/Criteria/ProductCriteriaExample.php) for more details.
```php
$criteria = ProducCriteriaExample::create()
     ->withFilter(FilterGroup::deserialize('(name like computer or name like pc) and price > 500 and price <= 1000'))
     ->withOrder(OrderGroup::deserialize('+price, stock desc'))
     ->withPaginate(Paginate::create(0, 5));
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
## Donation
If this project help you reduce time to develop, you can give me a cup of coffee :)

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/donate?hosted_button_id=8GHPEDM523NW4)
