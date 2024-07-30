(function($) {
    "use strict";

    $(document).ready(function() {

        /*
        ========================================
            counter Odometer
        ========================================
        */
        // function appgenixCounterup($scope, $) {
        //     $scope.find(".counter__count").each(function () {
        //         $(this).isInViewport(function(status) {
        //             if (status === "entered") {
        //                 for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
        //                     var el = document.querySelectorAll('.odometer')[i];
        //                     el.innerHTML = el.getAttribute("data-odometer-final");
        //                 }
        //             }
        //         });
        //     });
        // }

        function appgenixCounterup($scope, $) {
            $scope.find(".counter__count").each(function () {
                $(this).isInViewport(function (status) {
                    if (status === "entered") {
                        $scope.find(".odometer").each(function () {
                            var el = $(this);
                            el.html(el.data("odometer-final"));
                        });
                    }
                });
            });
        }



        let elementJSCallback = {
            'appgenix-promo-widget.default': appgenixCounterup,
        }
        $(window).on('elementor/frontend/init', function () {
            let $EF = elementorFrontend;
            $.each(elementJSCallback, function (widgetName, fuHandler) {
                $EF.hooks.addAction('frontend/element_ready/' + widgetName, fuHandler);
            })
        });
    });

})(jQuery);