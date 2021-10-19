<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule</title>
</head>
<body>
<h1>Schedule</h1>

<?php
//var_dump($_GET);
?>

<?php
if (isset($_GET['contacts'])) {
  $contacts = $_GET['contacts'];
} else {
  $contacts = array();
}

add_delete_contact($contacts);

function add_delete_contact(&$contactsRef)
{
  if (isset($_GET['submit'])) {
    $new_name = filter_input(INPUT_GET, 'name');
    $new_phone = filter_input(INPUT_GET, 'phone');

    if (empty($new_name)) {
      echo '<p style="color: crimson">Write a name please</p>';
    }
    if (empty($new_phone)) {
      unset($contactsRef[$new_name]);
    } elseif (strlen((string)$new_phone) < 9 || strlen((string)$new_phone) > 9) {
        echo '<p style="color: crimson">Write a valid phone number (9 digits)</p>';
    } else {
      $contactsRef[$new_name] = $new_phone;
    }
  }
}

function render_schedule($contactsRef)
{
  if (empty($contactsRef)) {
    echo '<h3>Empty schedule! No contacts found.</h3>';
    echo '<p>Add some contacts and try again.</p>';
  } else {
      echo '<h2>Contacts</h2>';
    echo '<ul>';
    foreach ($contactsRef as $name => $phone) {
      $final_name = ucfirst($name);
      echo "<li>$final_name: $phone</li>";
    }
    echo '</ul>';
  }
}

function render_form(&$contactsRef)
{
  ?>
    <form method="get">
      <?php
      foreach ($contactsRef as $name => $phone) {
        echo '<input type="hidden" name="contacts[' . $name . ']" value="' . $phone . '"/>';
      }
      ?>
        <label for="name"> Write your name:
            <input type="text" name="name" value="" placeholder="Name"/>
        </label><br>
        <label for="phone"> Write your phone:
            <input type="number" name="phone" value="" placeholder="Phone"/>
        </label><br>
        <button type="submit" name="submit">Send</button>
    </form>
  <?php
  render_schedule($contactsRef);
}

render_form($contacts);
?>

</body>
</html>
