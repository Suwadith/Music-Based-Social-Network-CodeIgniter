var ContactModel = Backbone.Model.extend({
    defaults: {
        // contactId: "",
        // userId: "",
        firstName: "",
        lastName: "",
        emailAddress: "",
        telephoneNumber: "",
        relationalTag: ""
    },

    idAttribute: 'contactId',

    urlRoot: "http://localhost/2015214/index.php/ApiController/contact",

    validate: function (attrs) {
        if(!attrs.firstName && !attrs.lastName && !attrs.emailAddress && !attrs.telephoneNumber){
            return "Only Relational Tag can be left empty!";
        }
    }
});

var ContactsCollection = Backbone.Collection.extend({
    model: ContactModel,
    url: "http://localhost/2015214/index.php/ApiController/contact"
});

var contacts = new ContactsCollection();

var ContactSearchView = Backbone.View.extend({
    el: "#search_contact_form",

    initialize : function () {
        this.$search_contact_list = this.$('#search_contact_list');
        this.$searchData = this.$('#searchData').hide();
    },
    render : function () {

        return this;
    },

    events : {
        "click #search" : 'searchContact',
        "click #returnAll" : 'getAll'
    },


    searchContact: function () {

        console.log('in');
        var lastName = $('#searchLastName').val();
        var relationalTag = $('#searchRelationalTag').val();
        console.log(lastName);
        console.log(relationalTag);
        var self = this;
        self.$search_contact_list.empty();

        if(lastName !== '' || relationalTag !== ''){
            // var contactss = new ContactsCollection();
            contacts.fetch({
                data: {
                    lastName: lastName,
                    relationalTag: relationalTag
                },
                success: function(response) {
                    console.log(response);
                    if(response.size()>0){
                        self.$searchData.show();
                    }else{
                        self.$searchData.hide();
                    }

                    response.each(function (contact) {

                        var view = new ContactResultView({model: contact});
                        self.$search_contact_list.append(view.render().el);
                    })

                    // console.log(contact);
                },
                error: function() {}
            });

        }else {
            // alert("Both the search fields can't be empty");
            self.$searchData.hide();

        }
    },

    getAll: function () {
        console.log('in');
        var self = this;
        self.$search_contact_list.empty();


            // var contactss = new ContactsCollection();
            contacts.fetch({
                data: {
                    lastName: '',
                    relationalTag: ''
                },
                success: function(response) {
                    console.log(response);
                    if(response.size()>0){
                        self.$searchData.show();
                    }else{
                        self.$searchData.hide();
                    }
                    response.each(function (contact) {

                        var view = new ContactResultView({model: contact});
                        self.$search_contact_list.append(view.render().el);
                    })

                    // console.log(contact);
                },
                error: function() {}
            });

    }
});

var ContactResultView = Backbone.View.extend({

    template: _.template($("#searchTable").html()),

    tagName: "tr",

    initialize : function () {
        this.$el.html(this.template(this.model.toJSON()));
    },

    events: {
        "click #deleteContact": "deleteContact"
    },

    render : function () {
        this.$el.attr("id", this.model.escape("contactId"));
        return this;
    },

    deleteContact: function (ev) {
        this.model.destroy();
        var $tr = $(ev.target).closest('tr');
        // Now $tr is the jQuery object for the <tr> containing the .delete
        // element that was clicked.
        $tr.remove();
    }
});

var contactSearchView = new ContactSearchView();


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
        el : $('#contact_list'),
        // connect view to page area
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

                var table = '<tr id="' + contact.get('contactId') + '"><td><h4 class="ui image header">' +
                    '<img src="https://semantic-ui.com/images/avatar2/small/matthew.png" class="ui mini rounded image">' +
                    '<div class="content">' + contact.get('firstName') + '<div class="sub header">' + contact.get('lastName') + '</div></div></h4></td>' +
                    '<td>' + contact.get('emailAddress') + '</td>' +
                    '<td>' + contact.get('telephoneNumber') + '</td>' +
                    '<td>' + contact.get('relationalTag') + '</td>' +
                    '<td><button class="ui red button" id="deleteContact">Delete</button></td></tr>';

                self.$el.append(table);

            })
        },
        events : {
            "click #deleteContact" : 'deleteContact'
        },

        deleteContact: function () {
            this.model.destroy();
        }
    }
);

var contentview = new ContactAreaView();
