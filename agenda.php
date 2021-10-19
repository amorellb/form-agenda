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
/**
 * Check if the GET array has a value named contacts. If so, then add its values to the contacts array.
 * If not set, then create an empty array called contacts.
 */
if (isset($_GET['contacts'])) {
  $contacts = $_GET['contacts'];
} else {
  $contacts = array();
}

add_delete_contact($contacts);

/**
 * A function which, given an array of contacts, checks if the form was submitted and put the name and phone sent
 * into two new variables.
 * Then checks if the name variable is empty, to show a warning message if it is. Also checks if the phone input is
 * empty, deleting the contact in this case or check the phone length, showing a proper message if it is larger or
 * shorter than 9 digits.
 * Finally, if the inputs are correct, both are added to the contacts array.
 * @param $contactsRef
 */
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

/**
 * A function which, given an array of contacts, prints an unordered list of existing contacts.
 * @param $contactsRef
 */
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

/**
 * A function which, given an array of contacts, prints a hidden input for every contact. Every hidden input are used
 * to make the data persistent while sending and receiving it from the 'server'
 * and to be able to print it into the list.
 * Also prints a form that asks to the user to write a name and a phone number.
 * @param $contactsRef
 */
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
