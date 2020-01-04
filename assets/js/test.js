var ContactModel = Backbone.Model.extend({
    defaults: {
        // contactId: "",
        userId: "",
        firstName: "",
        lastName: "",
        emailAddress: "",
        telephoneNumber: "",
        relationalTag: ""
    },

    idAttribute: 'contactId',

    urlRoot: "http://localhost/2015214/index.php/ApiController/contact",

    // validate: function (attrs) {
    //     if(!attrs.firstName && !attrs.lastName && !attrs.emailAddress && !attrs.telephoneNumber){
    //         return "Only Relational Tag can be left empty!";
    //     }
    // }
});

var ContactsCollection = Backbone.Collection.extend({
    model: ContactModel,
    url: "http://localhost/2015214/index.php/ApiController/contact"
});

var contacts = new ContactsCollection();

var ContactAddView = Backbone.View.extend({
    el: "#add_new_contact",

    initialize : function () {

    },
    render : function () {
        return this;
    },

    events : {
        "click #addNew" : 'addContact'
    },
    addContact : function () {
        console.log('creating contact model');
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var emailAddress = $('#emailAddress').val();
        var telephoneNumber = $('#telephoneNumber').val();
        var relationalTag = $('#relationalTag').val();
        console.log(firstName + lastName + emailAddress + telephoneNumber + relationalTag);
        var contact = new ContactModel({firstName : firstName, lastName : lastName, emailAddress : emailAddress,
            telephoneNumber : telephoneNumber, relationalTag: relationalTag});
        contact.save();
        contacts.add(contact);
        console.log('added celebrity ' + contact.get('lastName') + ' to collection')
    }

});

var contactAddView = new ContactAddView();

var ContactAreaView = Backbone.View.extend(
    {
        model: contacts, // connect view to collections object
        el : $('#contact_list'), // connect view to page area
        initialize : function () {
            // when view object created, we want something to
            // happen to load initial content
            contacts.fetch({async:false});
            this.render();
            this.model.on('add', this.render, this);
        },
        render : function () {
            // display content
            var self = this;
            this.$el.empty();
            contacts.each(function (contact) {
                // var cimg = "<div class='celebimg'><img src='" + c.get('imageurl') + "'>";
                // self.$el.append(cimg)

                var table = '<tr><td><h4 class="ui image header">' +
                    '<img src="https://semantic-ui.com/images/avatar2/small/matthew.png" class="ui mini rounded image">' +
                    '<div class="content">' + contact.get('firstName') + '<div class="sub header">' + contact.get('lastName') + '</div></div></h4></td>' +
                    '<td>' + contact.get('emailAddress') + '</td>' +
                    '<td>' + contact.get('telephoneNumber') + '</td>' +
                    '<td>' + contact.get('relationalTag') + '</tr>';
                self.$el.append(table);

            })
        }
    }
);

var contentview = new ContactAreaView();
