# PhpGenHTML
A little php framework to easily generate clean html code, with automatic identation.

You can use it like this to make a connection form :

```php
<?php
  
include('fonctions/view.php');
  
echo $view->formulaire(array(
    new input(array('name' => 'username', 'id' => 'username', 'placeholder' => 'Pseudo')),
    new input(array('name' => 'password', 'type' => 'password', 'id' => 'password', 'placeholder' => 'Password')),
    new input(array('type' => 'submit', 'value' => 'Connection'))
  ), array(
    'method' => 'post'
  ));
  
  if(!empty($view)){
    echo $view->body_end();
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
