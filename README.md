# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic identation.
#It's an old documentation, don't use it, it's updating
You can use it like this to make a connection form :

```php
include('view.php');

use PhpGenHTML as PGH;

$view = New PGH\View();
echo $view->start();

echo $view->form(array(
		new PGH\input(array('name' => 'username', 'id' => 'username', 'placeholder' => 'Pseudo')),
		new PGH\input(array('name' => 'password', 'type' => 'password', 'id' => 'password', 'placeholder' => 'Password')),
		new PGH\input(array('type' => 'submit', 'value' => 'Connection'))
	), array(
		'method' => 'post'
	));

if(!empty($view)){
	echo $view->bodyEnd();
	echo $view->end();
}
```
  
to get in output :

```html
<!DOCTYPE html>
<html>
  <form method="post">
    <input name="username" id="username" placeholder="Pseudo" type="text">
    <input name="password" type="password" id="password" placeholder="Password">
    <input type="submit" value="Connection">
  </form>
</html>
```



## Documentation
###### Loading
You must include the code file.
```php
include('view.php');
```
You can use an alias to code faster, with less chars.
```php
use PhpGenHTML as PGH;
```
Make into a variable PGH object.
```php
$view = New PGH\View();
```
Print the return of the **start()** function to print the html doctype and the html start tag.
```php
echo $view->start();
```

**_Loading Example_** :
```php
include('view.php');
use PhpGenHTML as PGH;
$view = New PGH\View();
echo $view->start();
```
