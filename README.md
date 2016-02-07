# PhpGenHTML
A little PHP framework to easily generate clean HTML code, with automatic identation.

You can use it like this to make a connection form :

```php
include('fonctions/view.php');

use PhpGenHTML as PGH;

$view = New PGH\View();
echo $view->start();

echo $view->form(array(
		new PGH\input(array('name' => 'username', 'id' => 'username', 'placeholder' => 'Pseudo')),
		new PGH\input(array('name' => 'password', 'type' => 'password', 'id' => 'password', 'placeholder' => 'Mot de passe')),
		new PGH\input(array('type' => 'submit', 'value' => 'Connexion'))
	), array(
		'method' => 'post'
	));

if(!empty($view)){
	echo $view->bodyEnd();
	echo $view->end();
}
```
  
the return :

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
