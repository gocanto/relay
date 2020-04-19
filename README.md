## About it
<a href="https://packagist.org/packages/gocanto/relay"><img src="https://img.shields.io/packagist/dt/gocanto/relay.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/gocanto/relay"><img src="https://img.shields.io/github/v/release/gocanto/relay.svg" alt="Latest Stable Version"></a>
<a href="https://github.com/gocanto/relay/actions"><img src="https://github.com/gocanto/relay/workflows/build/badge.svg" alt="Build status"></a>

Relay is a data transfer objects structure that allows you to consume third party API payloads and parse them into their
proper type object throughout a promotion mapper to ensure given incoming data abides by its expected type. 

## How does it work?
Relay is a self-contained attribute bag that maps their values using promoters that parse given incoming payloads into
valid data transfer objects. Thus, you will be able to remove the ability to work with unstructured data in your
application by using proper types through wrappers that take care of any sanitation and constraints validation logic. 

## What are promoters?
A promoter is a data structure that allows us to map given data with the desired data type. By doing so, we will be able
to guard unknown payloads using proper types. For instance, you can specify that a `first_name` key value is the type
`text` to prevent the transfer object from being created on constraints failures.

Furthermore, you will have the ability to mark keys value as `Any` if you are not sure of the data type it belongs to.

## Case of study
Let's imagine we are consuming a third party API from an event platform to persist it in our database. Usually, you will
be given users information such as email, name or profile URL. This is a pretty challenging case scenario since you will
have to validate and sanitize the incoming payload to avoid having inconsistent data in your application.

Now, if you are anything like me, you might be thinking of parsing the incoming payload into an array, and then validate
key-value by accessing the array and asking whether we have got the valid information. Such as:

```php
$payload = [
    'name' => 'Gustavo',
    'email' => 'gustavoocanto@gmail.com',
    'profile_url' => 'http://foo.com/gocanto',
];

if (isset($payload['name']) && is_string($payload['name'])) {
    //do something amazing!
}

//is_valid_email is a imaginary function that should check whether a given email is valid or not.
if (isset($payload['email']) && is_valid_email($payload['email'])) { 
    //do something amazing!
}

//is_valid_url is a imaginary function that should check whether a given URL is valid or not.
if (isset($payload['profile_url']) && is_valid_email($payload['profile_url'])) { 
    //do something amazing!
}
```
As you can see here, this can go out hands pretty quickly for many reasons. To mention some, we could say the following: 

- You will have to repeat yourself every time you need to reference this information in your app.
- These validations do not take into account more complicated validations. Such as, different type of emails, URL or more complex string rules.
- Having unstructured data promotes the way of introducing many bugs into your application by tapping functionality at any given time. 

> Nevertheless, we are good programmers and like to do better. Furthermore, we love working with `types` don't we? 

## Using relay to handle your payloads.
after you have installed the relay data transfer in your application, you will be able to consume the above payload like so

```php
declare(strict_types=1);

use Gocanto\Relay\Attributes;
use Gocanto\Relay\Types\Url;
use Gocanto\Relay\Types\Email;
use Gocanto\Relay\Types\Text;
use Gocanto\Relay\Promoter;

$data = [
    'name' => 'Gustavo',
    'email' => 'gustavoocanto@gmail.com',
    'profile_url' => 'http://foo.com/gocanto',
];

class Payload extends Attributes
{
}

$payload = new Payload($data, [
    'name' => Promoter::make(Text::class),
    'email' => Promoter::make(Email::class),
    'profile_url' => Promoter::make(Url::class),
]);

/** @var Text $name */
$name = $payload->get('name');

/** @var Email $email */
$email = $payload->get('email');

/** @var Url $profileUrl */
$profileUrl = $payload->get('profile_url');
```
Furthermore, you will be given an Any object wrapper if the asked payload key does not have a specified mapping or was
marked as optional using the `::optional()` [construct method](https://github.com/gocanto/relay/blob/master/src/Promoter.php#L54) within the promoter object.

***Note:*** Any key-value specified in your payload mapper is marked as required

If you would like to know more about the functionality and different uses, please click on [here](https://github.com/gocanto/relay/tree/master/tests).

## Supported types
- [x] boolean
- [x] integer
- [x] Float (floating-point number, aka double)
- [x] string
- [x] mixed
- [x] number
- [x] Url
- [x] Email
- [x] Uuid
- [x] Date

## Future scopes.
- [ ] Easier mapping mechanism.
- [ ] Add more types.
- [ ] Add tests for `dot` array access.
- [ ] Have an idea?

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/relay/blob/master/LICENSE.md) for 
more information.

## How can I thank you?
Why not star the github repo and share the link for this repository on Twitter?

Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!

Gustavo Ocanto.




