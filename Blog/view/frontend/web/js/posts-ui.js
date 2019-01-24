define([
        'uiComponent',
        'jquery',
        'ko'
    ],function (Component, $, ko) {
        "use strict";
        var vitConfig = function (config)
        { };
        var listTitle =  ko.observableArray();
        return Component.extend({
            visible: ko.observable(false),
            // categoryId: vitConfig.categoryId,
            url: vitConfig.url,
            getUrlNewPost :function (){
                var urlNewPost = vitConfig.urlNewPost;
                return urlNewPost;
            },
            getListTitle : function(){
               var self = this;
                    $.ajax({
                        url:self.url,
                        type: 'GET',
                        dataType: 'json',
                        complete: function (data) {

                           if(data.responseText.length === 2){
                               self.visible(true);
                           }
                           listTitle(JSON.parse(data.responseText));
                        }
                    });
                return listTitle;
            }
        });
    });