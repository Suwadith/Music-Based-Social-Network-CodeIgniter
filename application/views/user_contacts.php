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

    .errorMessage {
        color: red;
    }
</style>

<div class="search_contact_form" id="search_contact_form">
    <form action="" method="GET">
    <div class="ui segment ui input focus textField">
        <input type="text" id="lastName" name="lastName" placeholder="Last Name / Surname" value="" required>
    </div>

    <div class="ui segment ui input focus tagField">
        <div class="ui fluid search selection dropdown">
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
    <button class="ui grey button" type="submit">Submit</button>
    <br><br>
    </form>

    <div id="contactTitle">
    </div>
</div>
<script>
    $('.ui.dropdown').dropdown();

    $('.ui .input').on('click', function () {
        $('.ui .input').removeClass('active');
        $(this).addClass('active');
    });
</script>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>-->
<script src="/2015214/assets/js/underscore-min.js"></script>
<script src="/2015214/assets/js/backbone-min.js"></script>
<script type="text/javascript" src="/2015214/assets/js/models/contact.js"></script>
<script type="text/javascript" src="/2015214/assets/js/collections/contacts.js"></script>
<script type="text/javascript" src="/2015214/assets/js/views/contactView.js"></script>
<script type="text/javascript" src="/2015214/assets/js/views/contactsView.js"></script>
<script type="text/javascript" src="/2015214/assets/js/main.js"></script>

<!--<script language="javascript">-->
<!---->
<!--    var Contact = Backbone.Model.extend({-->
<!--        url : function () {-->
<!--            return "http://localhost/2015214/index.php/ApiController/contact?lastName=" + this.get('lastName') + "&relationalTag=" + this.get('relationalTag');-->
<!--        },-->
<!--        default : {-->
<!--            contactId : '',-->
<!--            userId : '',-->
<!--            firstName : '',-->
<!--            lastName : '',-->
<!--            emailAddress : '',-->
<!--            telephoneNumber : '',-->
<!--            relationalTag : ''-->
<!--        }-->
<!--    });-->
<!---->
<!--    var contact = new Contact({lastName : '', relationalTag: ''});-->
<!---->
<!--    var ContactView = Backbone.View.extend({-->
<!--        el : "#search_contact_form",-->
<!--        events : {-->
<!--            "submit form" : "getcontact"-->
<!--        },-->
<!--        initialize : function () {-->
<!--            this.listenTo(this.model,"sync change",this.displayContact)-->
<!--        },-->
<!--        getcontact : function (event) {-->
<!--            event.preventDefault();-->
<!--            this.model.set({lastName: $('#lastName').val(), relationalTag: $('#relationalTag').val()});-->
<!--            this.model.fetch({-->
<!--               success: function (response) {-->
<!--                   console.log(response.toJSON());-->
<!--               }-->
<!--            });-->
<!---->
<!--        },-->
<!--        displayContact : function () {-->
<!--            $('#contactTitle').html(this.model.get('lastName') + this.model.get('relationalTag'));-->
<!--            // console.log(this.model);-->
<!--        }-->
<!--    });-->
<!--    view = new ContactView({model : contact});-->
<!---->
<!--    //movie.fetch();-->
<!--    //movie.on("change",function (model) {-->
<!--    //    alert('Title is ' + model.get('title') + ' for year ' + model.get('year'));-->
<!--    //});-->
<!---->
<!---->
<!--</script>-->


<script>
    document.title = "Contacts List";
</script>
