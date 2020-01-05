var Contact = Backbone.Model.extend({
    defaults: {
        firstName: "",
        lastName: "",
        emailAddress: "",
        telephoneNumber: "",
        relationalTag: ""
    },

    idAttribute: 'contactId',

    urlRoot: "http://localhost/2015214/index.php/ApiController/contact",

    validate: function (attrs) {
        if (!attrs.firstName && !attrs.lastName && !attrs.emailAddress && !attrs.telephoneNumber) {
            return "Only Relational Tag can be left empty!";
        }
    }
});

var Contacts = Backbone.Collection.extend({
    model: Contact,
    url: "http://localhost/2015214/index.php/ApiController/contact"
});

var contacts = new Contacts();

var ContactSearchView = Backbone.View.extend({

    el: "#search_contact_form",

    initialize: function () {
        this.$search_contact_list = this.$('#search_contact_list');
        this.$searchData = this.$('#searchData');

        this.$searchData.hide();
        $('#add_new_contact').hide();


    },

    render: function () {
        return this;
    },

    events: {
        "click #search": 'searchContact',
        "click #returnAll": 'getAll',
        "click #addNewContact": 'addNewContactPage'
    },

    addNewContactPage:function () {
        $('#add_new_contact').show();
        $('#searchData').hide();
        $("#edit_contact").hide();
    },


    searchContact: function () {
        $('#add_new_contact').hide();

        var lastName = $('#searchLastName').val();
        var relationalTag = $('#searchRelationalTag').val();

        var self = this;
        self.$search_contact_list.empty();


        if (lastName !== '' || relationalTag !== '') {
            contacts.fetch({
                data: {
                    lastName: lastName,
                    relationalTag: relationalTag
                },

                success: function (response) {
                    if (response.size() > 0) {
                        self.$searchData.show();
                    } else {
                        alert('No contacts found');
                        self.$searchData.hide();
                    }
                    response.each(function (contact) {
                        var view = new ContactResultView({model: contact});
                        self.$search_contact_list.append(view.render().el);
                    })

                },

                error: function () {
                }
            });

        } else {
            alert('At least one of the search parameters has to be filled');
            self.$searchData.hide();
        }
    },

    getAll: function () {
        $('#add_new_contact').hide();
        $("#edit_contact").hide();

        var self = this;
        self.$search_contact_list.empty();

        contacts.fetch({
            success: function (response) {
                if (response.size() > 0) {
                    self.$searchData.show();
                } else {
                    self.$searchData.hide();
                    alert('No contacts found');
                }
                response.each(function (contact) {
                    var view = new ContactResultView({model: contact});
                    self.$search_contact_list.append(view.render().el);
                })

            },
            error: function () {
            }
        });

    }
});

var ContactResultView = Backbone.View.extend({

    template: _.template($("#searchTable").html()),

    tagName: "tr",

    initialize: function () {
        this.$el.html(this.template(this.model.toJSON()));
    },

    events: {
        "click #deleteContact": "deleteContact",
        "click #editContact": "editContact",
    },

    render: function () {
        this.$el.attr("id", this.model.escape("contactId"));
        return this;
    },

    editContact: function () {
        $("#edit_contact").show();
        $('#searchData').hide();
        $('#add_new_contact').hide();

        contactEditView.setDetails(this.model);
    },

    deleteContact: function (element) {
        this.model.destroy();
        var tableRow = $(element.target).closest('tr');
        tableRow.remove();
    }
});

var contactSearchView = new ContactSearchView();


var ContactAddView = Backbone.View.extend({
    el: "#add_new_contact",


    initialize: function () {

    },
    render: function () {
        return this;
    },

    events: {
        "click #addNew": 'addContact'
    },
    addContact: function () {
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var emailAddress = $('#emailAddress').val();
        var telephoneNumber = $('#telephoneNumber').val();
        var relationalTag = $('#relationalTag').val();

        if(firstName.length !== 0 && lastName.length !== 0 && emailAddress.length !== 0 && telephoneNumber.length !== 0) {
            var contact = new Contact({
                firstName: firstName,
                lastName: lastName,
                emailAddress: emailAddress,
                telephoneNumber: telephoneNumber,
                relationalTag: relationalTag
            });

            contact.save();
            contacts.add(contact);

            $('#add_new_contact').hide();
        } else {
            alert('Only the relational tag is an optional input');
        }


    }

});

var contactAddView = new ContactAddView();

var ContactEditView = Backbone.View.extend({

    el: "#edit_contact",


    initialize: function () {
        $("#edit_contact").hide();
    },
    render: function () {
        return this;
    },

    setDetails: function(contact) {
        this.model = contact;

        $('#editFirstName').val(contact.get("firstName"));
        $('#editLastName').val(contact.get("lastName"));
        $('#editEmailAddress').val(contact.get("emailAddress"));
        $('#editTelephoneNumber').val(contact.get("telephoneNumber"));
        $('#editRelationalTag').val(contact.get("relationalTag"));
        $('#relationship').text("Selected value: " + contact.get("relationalTag"));
    },


    events: {
        "click #edit": 'editContact'
    },
    editContact: function () {


        var firstName = $('#editFirstName').val();
        var lastName = $('#editLastName').val();
        var emailAddress = $('#editEmailAddress').val();
        var telephoneNumber = $('#editTelephoneNumber').val();
        var relationalTag = $('#editRelationalTag').val();

        if (firstName.length !== 0 && lastName.length !== 0 && emailAddress.length !== 0 && telephoneNumber.length !== 0) {

            this.model.set({
                firstName: firstName,
                lastName: lastName,
                emailAddress: emailAddress,
                telephoneNumber: telephoneNumber,
                relationalTag: relationalTag
            });

            this.model.save();
            $("#edit_contact").hide();
        } else {
            alert('Only the relational tag is an optional input');
        }
    }


});

var contactEditView = new ContactEditView();


// var ContactAreaView = Backbone.View.extend(
//     {
//         model: contacts, // connect view to collections object
//         el: $('#contact_list'),
//         // connect view to page area
//         initialize: function () {
//             // when view object created, we want something to
//             // happen to load initial content
//             contacts.fetch({async: false});
//             this.render();
//             this.model.on('add', this.render, this);
//         },
//         render: function () {
//             // display content
//             var self = this;
//             this.$el.empty();
//             contacts.each(function (contact) {
//                 // var cimg = "<div class='celebimg'><img src='" + c.get('imageurl') + "'>";
//                 // self.$el.append(cimg)
//
//                 var table = '<tr id="' + contact.get('contactId') + '"><td><h4 class="ui image header">' +
//                     '<img src="https://semantic-ui.com/images/avatar2/small/matthew.png" class="ui mini rounded image">' +
//                     '<div class="content">' + contact.get('firstName') + '<div class="sub header">' + contact.get('lastName') + '</div></div></h4></td>' +
//                     '<td>' + contact.get('emailAddress') + '</td>' +
//                     '<td>' + contact.get('telephoneNumber') + '</td>' +
//                     '<td>' + contact.get('relationalTag') + '</td>' +
//                     '<td><button class="ui red button" id="deleteContact">Delete</button></td></tr>';
//
//                 self.$el.append(table);
//
//             })
//         },
//         events: {
//             "click #deleteContact": 'deleteContact'
//         },
//
//         deleteContact: function () {
//             this.model.destroy();
//         }
//     }
// );
//
// var contentview = new ContactAreaView();
