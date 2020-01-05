var ContactItemView = Backbone.View.extend({
    tagName: "li",
    initialize: function(options) {
        if(!(options && options.model)){
            throw new Error("model is not specified.");
        }

        // this.model.on("destroy", this.onClickDelete, this);
    },

    events: {
        "click #delete": "onClickDelete"
    },

    onClickDelete: function() {
        // console.log("Delete Clicked");
        this.model.destroy(
            //     {
            //     success: function() {
            //         $(event.currentTarget).closest('li').remove();
            //         console.log("Deleted");
            //     }
            // }
        );
    },

    render: function () {
        this.$el.attr("id", this.model.escape("contactId"));

        this.$el.html(this.model.escape("firstName") + " " + this.model.escape("lastName") + " " + this.model.escape("emailAddress") + " " +
            this.model.escape("telephoneNumber") + " " + this.model.escape("relationalTag") + " <button id='delete'>Delete</button>");

        return this;
    }
});