var ContactItemsView = Backbone.View.extend({
    tagName: "ul",
    // el: ".search_contact_form",
    id: "contactItems",

    initialize: function(options) {
        if(!(options && options.model)){
            throw new Error("model is not specified.");
        }

        this.model.on("search", this.onSearchContact, this);
        this.model.on("add", this.onAddContact, this);
        this.model.on("remove", this.onRemoveContact, this);
    },

    renderSearch() {
        // this.$el.append("<div class='ui segment ui input focus textField'> " +
        //     "<input type='text' id='lastName' name='lastName' " +
        //     "placeholder='Last Name / Surname' value='' required></div>");
        this.$el.append("<input type='text' id='lastName' autofocus>");
        this.$el.append("<input type='text' id='relationalTag'>");
        this.$el.append("<button id='search'>Search</button>");
        this.$el.append("<button id='new'>New</button>");
    },

    onSearchContact: function(contact) {
        var view = new ContactItemView({model: contact});
        this.$el.append(view.render().$el);
    },

    onAddContact: function(contact){
        // console.log("Added");
        var view = new ContactItemView({model: contact});
        this.$el.append(view.render().$el);
    },

    onRemoveContact: function(contact) {
        console.log("Removed", contact);
        this.$("li#" + contact.id).remove();
    },

    events: {
        "click #search": "onClickSearch",
        "click #add": "onClickAdd",
        "keypress #newContact": "onKeyPress"
    },

    onKeyPress: function(e) {
        if(e.keyCode === 13) {
            // console.log("Enter pressed");
            this.onClickAdd();
        }

    },

    onClickAdd: function() {
        var textBox = this.$("#newContact");
        // console.log("clicked");
        // var contact = new Contact({emailAddress: "ragul@gmail.com"});
        if(textBox.val()){
            var contact = new Contact({emailAddress: textBox.val()});
            this.model.add(contact);

            textBox.val("");
        }

    },

    onClickSearch: function() {
        var lastNameBox = this.$("#lastName");
        var relationalTagBox = this.$("#relationalTag");
        var self = this;
        self.$el.empty();
        this.renderSearch();
        if(lastNameBox.val() !== '' || relationalTagBox.val() !== ''){
            var contacts = new Contacts();
            contacts.fetch({
                data: {
                    lastName: lastNameBox.val(),
                    relationalTag: relationalTagBox.val()
                },
                success: function(response) {
                    console.log(response);

                    response.each(function (contact) {
                        var view = new ContactItemView({model: contact});
                        self.$el.append(view.render().$el);
                    })

                    // console.log(contact);
                },
                error: function() {}
            });

        }else {
            alert("Both the search fields can't be empty");
        }
    },


    render: function () {

        // var self = this;

        this.renderSearch();

        // this.$el.append("<input type='text' id='newContact' autofocus>");
        // this.$el.append("<button id='add'>Add</button>");
        //
        // this.model.each(function (contact) {
        //     var view = new ContactItemView({model: contact});
        //     self.$el.append(view.render().$el);
        // });

        return this;
    }
});