<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 12/29/2019
 * Time: 10:55 PM
 */

?>

<style>
    .textField {
        min-width: 40%;
    }

    .tagField {
        min-width: 20%;
    }

    .search_contact_form {
        min-width: 80%;
        text-align: center;
    }


    #searchData {
        min-width: 80%;
        text-align: center;
    }

    .errorMessage {
        color: red;
    }

    #relationship {
        color: black;
    }
</style>

<div class="search_contact_form" id="search_contact_form">

    <div class="ui segment ui input focus textField">
        <input type="text" id="searchLastName" name="searchLastName" placeholder="Last Name / Surname" value=""
               required>
    </div>

    <div class="ui segment ui input focus tagField">
        <div class="ui fluid search selection dropdown">
            <input type="hidden" name="searchRelationalTag" id="searchRelationalTag" value="">
            <i class="dropdown icon"></i>
            <div class="default text">Select Relationship</div>
            <div class="menu">
                <div class="item" data-value="">None</div>
                <div class="item" data-value="family">Family</div>
                <div class="item" data-value="friend">Friend</div>
                <div class="item" data-value="work">Work</div>
            </div>
        </div>
    </div>
    <br><br>
    <button id="search" class="ui grey button">Search</button>
    <button id="returnAll" class="ui grey button">Get All Contacts</button>
    <button id="addNewContact" class="ui blue button">Add New Contact</button>
    <br><br>


    <div id="searchData" class="ui raised very padded text container segment">

        <table class="ui celled padded table">
            <thead>
            <tr><th class="single line">Name</th>
                <th>Email Address</th>
                <th>Telephone Number</th>
                <th>Relational Tag</th>
                <th>Options</th>
            </tr></thead>
            <tbody id="search_contact_list">


            </tbody>
        </table>

    </div>

</div>

<script type="text/template" id="searchTable">

        <td>
            <h4 class="ui image header">
                <img src="https://semantic-ui.com/images/avatar2/small/matthew.png" class="ui mini rounded image">
                <div class="content">
                    <%= lastName %>
                    <div class="sub header">
                        <%= firstName %>
                    </div>
                </div>
            </h4>
        </td>
        <td>
            <%= emailAddress %>
        </td>
        <td>
            <%= telephoneNumber %>
        </td>
        <td>
            <%= relationalTag %>
        </td>
        <td>
            <button class="ui blue button" id="editContact">Edit</button>

            <button class="ui red button" id="deleteContact">Delete</button>
        </td>

</script>



<div class="add_new_contact ui raised very padded text container segment center aligned" id="add_new_contact" >
    <div class="ui segment ui input focus textField">
        <input type="text" id="firstName" name="firstName" placeholder="First Name" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="email" id="emailAddress" name="emailAddress" placeholder="example@gmail.com" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="text" id="telephoneNumber" name="telephoneNumber" placeholder="+94714150056" value="" required>
    </div>

    <div class="ui segment ui input focus tagField" style="min-width: 80%">
        <div class="ui fluid multiple search selection dropdown">
            <input type="hidden" name="relationalTag" id="relationalTag" value="">
            <i class="dropdown icon"></i>
            <div class="default text">Select Relationship</div>
            <div class="menu">
                <div class="item" data-value="family">Family</div>
                <div class="item" data-value="friend">Friend</div>
                <div class="item" data-value="work">Work</div>
            </div>
        </div>
    </div>
    <br><br>
    <button id="addNew" class="ui grey button">Submit</button>
    <br><br>


</div>

<div class="edit_contact ui raised very padded text container segment center aligned" id="edit_contact" >
    <div class="ui segment ui input focus textField">
        <input type="text" id="editFirstName" name="editFirstName" placeholder="First Name" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="text" id="editLastName" name="editLastName" placeholder="Last Name" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="email" id="editEmailAddress" name="editEmailAddress" placeholder="example@gmail.com" value="" required>
    </div>
    <div class="ui segment ui input focus textField">
        <input type="text" id="editTelephoneNumber" name="editTelephoneNumber" placeholder="+94714150056" value="" required>
    </div>

    <div class="ui segment ui input focus tagField" style="min-width: 80%">
        <div class="ui fluid multiple search selection dropdown">
            <input type="hidden" name="editRelationalTag" id="editRelationalTag" value="">
            <i class="dropdown icon"></i>
            <div id="relationship" class="default text">Select Relationship</div>
            <div class="menu">
                <div class="item" data-value="family">Family</div>
                <div class="item" data-value="friend">Friend</div>
                <div class="item" data-value="work">Work</div>
            </div>
        </div>
    </div>
    <br><br>
    <button id="edit" class="ui grey button">Submit</button>
    <br><br>


</div>


<script>
    $('.ui.dropdown').dropdown();

    $('.ui .input').on('click', function () {
        $('.ui .input').removeClass('active');
        $(this).addClass('active');
    });
</script>


<script src="/2015214/assets/js/underscore-min.js"></script>
<script src="/2015214/assets/js/backbone-min.js"></script>
<script type="text/javascript" src="/2015214/assets/js/main.js"></script>


<script>
    document.title = "Contacts List";
</script>
