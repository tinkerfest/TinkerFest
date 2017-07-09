$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
});
        
Array.prototype.extend = function ( ar ) {
    ar.forEach(function (v) {
        this.push(v)
    }, this)
};
var collectionSize  = 12, timeout = null;

var panel51 = new Vue({
    el: "#panel51",
    data: {
        text        : "",
        users       : [],
        dataloading : false,
        pdata       : [],
        lastOffset  : 0,
        end_of_results: false,
        searchRequest : { abort : function(){} },
        colors      : ['red darken-1', 'grey darken-3', 'pink darken-1', 'teal darken-3', 'purple darken-2', 'yellow darken-2', 'indigo accent-4', 'green darken-2', 'deep-orange', 'deep-purple darken-3', 'mdb-color darken-3', 'cyan darken-2', 'brown']
    },
    mounted: function () {
        var self = this;
        self.search();
    },

    methods: {
        typed: function (e) {
            clearTimeout(timeout);
            var self = this;
            timeout = setTimeout(function () {
              self.end_of_results = false;
              self.lastOffset = 0;
              self.users = [];
              self.search();
            }, 500);
        },
        search: function(e){

            var self = this;
            self.dataloading = true;
            self.searchRequest.abort();
                self.searchRequest = $.post('/api/search', {
                    'type': 'user',
                    'offset': self.lastOffset,
                    'limit': self.lastOffset + collectionSize,
                    'qry': self.text,
                })
                .done(function (response) {              
                        self.users.extend(response.collection);
                        self.lastOffset += self.users.length;
                        self.dataloading = false;
                        if( response.collection.length == 0 ){
                            self.end_of_results = true;
                        }
                })
        },
        getColor: function (name, salt1, salt2) {
            name = name + "_" + salt1 + "+6" + salt2;
            var t = 0;
            for (var i = 0; i < name.length; i++) {
                name.charCodeAt(i).toString(2).split('').map(function (n) {
                    t += parseInt(n)
                });
            }
            t = t % this.colors.length;
            return this.colors[t];
        }
    }
});










var panel52 = new Vue({
    el: "#panel52",
    data: {
        text: "",
        categories: [],
        collection: [],
        logsCollection: [],
        dataloading: false,
        lastOffset: 0,
        end_of_results: false,
        searchRequest : { abort : function(){} },
    },
    mounted: function () {
        var self = this;
        $.post('/api/category', {}).done(function (response) {
            self.categories = response.collection.map(function (e) {
                e.checked = false;
                return e;
            });
        }); 
        self.search();
    },
    methods: {
        typed: function (e) {
            clearTimeout(timeout);
            var self = this;
            timeout = setTimeout(function () {
                self.end_of_results = false;
                self.lastOffset = 0;
                self.logsCollection = [];
                self.search();
            }, 500);
        },
        search: function (e) {
            var self = this;
            self.dataloading = true;
            self.searchRequest.abort();

            var chkCat = self.categories.filter(function (element) {
                return element.checked
            });
                self.searchRequest = $.post('/api/search', {
                    'type': 'post',
                    'offset': self.lastOffset,
                    'limit': self.lastOffset + collectionSize,
                    'categories': chkCat,
                    'qry': self.text,
                })
                .done(function (response) {

                    self.logsCollection.extend(response.collection);
                    self.lastOffset += self.logsCollection.length;
                    self.dataloading = false;
                    if( response.collection.length == 0 ){
                        self.end_of_results = true;
                    }
                })
        },
        makeUrl: function () {
            var x = "";
            if (arguments.length > 0) {
                for (var i in arguments) {
                    x += "/" + arguments[i];
                }
                return x;
            }
            return "/";
        },
        getLimit: function (str, lmt) {
            // console.log(str,lmt);
            if (str.length > lmt + 5) {
                var s = str.substr(0, lmt);
                s = s.split(" ");
                s.pop();
                return s.join(" ") + "...";
            }
            return str;
        },
        searchOnCheck : function(){
            this.end_of_results = false;
            this.lastOffset = 0;
            this.logsCollection = [];
            this.search();
        },

    },
    
})

var MainScope = new Vue({
    el: "#app-main",
    mounted: function () {
        var self = this;
        var throttleTimer = null;
        var throttleDelay = 200;
        var $window = $(window);
        var $document = $(document);

            $window
                .off('scroll', ScrollHandler)
                .on('scroll', ScrollHandler);
        
        function ScrollHandler(e) {
            var panel;
            if ($("#fellowMakers").hasClass('active')) {
                panel = panel51;
            } else if($("#recentLogs").hasClass('active')) {
                panel = panel52;
            }
            // console.log(panel.$el)
            //throttle event:
            clearTimeout( throttleTimer );
             throttleTimer  = setTimeout(function () {

                if ($window.scrollTop() + $window.height() > $document.height() - 50) {
                    if (!panel.dataloading) {
                        panel.search();
                    }
                }

            },  throttleDelay );
        }


    }
})