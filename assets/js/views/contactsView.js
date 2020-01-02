var ContactItemsView = Backbone.View.extend({
    tagName: "ul",
    id: "contactItems",

    initialize: function(options) {
        if(!(options && options.model)){
            throw new Error("model is not specified.");
        }

        // this.model.on("search", this.onSearchContact, this);
        this.model.on("add", this.onAddContact, this);
        this.model.on("remove", this.onRemoveContact, this);
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

   render: function () {

       var self = this;

       this.$el.append("<input type='text' id='newContact' autofocus>");
       this.$el.append("<button id='add'>Add</button>");

       this.model.each(function (contact) {
           var view = new ContactItemView({model: contact});
           self.$el.append(view.render().$el);
       });

       return this;
   } 
});