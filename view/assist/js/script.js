let x = document.querySelectorAll(".CurNumDiv");
for (let i = 0, len = x.length; i < len; i++) {
    let num = Number(x[i].innerHTML)
        .toLocaleString('en');
    x[i].innerHTML = num;
}


// var options = {
//   series: [40, 20, 10, 30],
//   chart: {
//     width: 380,
//     type: 'donut',
//   },
//   labels: ["دالر", "افغانی", "تومان", "کالدار", ],
//   dataLabels: {
//     enabled: false
//   },
//   responsive: [{
//     breakpoint: 480,
//     options: {
//       chart: {
//         width: 200
//       },
//       legend: {
//         show: false
//       }
//     }
//   }],
//   legend: {
//     position: 'left',
//     offsetY: 0,
//     height: 170,
//   }
// };

// var chart = new ApexCharts(document.querySelector("#chart2"), options);
// chart.render();


// $(document).ready(function() {
//     $('#datatable').DataTable( {
//         // "paging":   false,
//         "searching": false,
//         "info": false,
//         "language.autoFill.info": false
//     } );
// } );

// $(document).ready(function () {
//   "use strict";
//   $("#datatable").DataTable({
//     "info": false,
//     "searching": false,
//     "lengthChange": false,
//     "processing": true,
//     responsive: true,
//     columns: [
//         { responsivePriority: 6 },
//         { responsivePriority: 5 },

//     ],
//     keys: !0,
//     language: {
//       "infoEmpty": "هیچ معلوماتی برای نمایش وجود ندارد! ",
//       paginate: {
//       previous: "<i class='fas fa-chevron-right'></i>",
//       next: "<i class='fas fa-chevron-left'></i>"
//       }
//     },

//   });
// });



$(document).ready(function() {
    "use strict";

    var a = $("#datatable").DataTable({
        "info": false,
        "searching": false,
        "lengthChange": false,
        "processing": true,
        paging: false,
        lengthChange: !1,
        // buttons: ["copy", "print"],

        language: {
            infoEmpty: "هیچ معلوماتی برای نمایش وجود ندارد! ",
        },

    });


    $(".dataTables_length select").addClass("form-select form-select-sm"), $(".dataTables_length label").addClass("form-label")
});

$(document).ready(function() {
    "use strict";

    var a = $("#datatable2").DataTable({
        "info": false,
        "searching": false,
        "lengthChange": false,
        "processing": true,
        paging: false,
        lengthChange: !1,
        // buttons: ["copy", "print"],

        language: {
            infoEmpty: "هیچ معلوماتی برای نمایش وجود ندارد! ",
        },

    });


    $(".dataTables_length select").addClass("form-select form-select-sm"), $(".dataTables_length label").addClass("form-label")
});

// $(document).ready(function () {
//   "use strict";

//   var a = $("#datatable2").DataTable({
//     "info": false,
//     "searching": false,
//     "lengthChange": false,
//     "processing": true,
//     paging: true,
//     lengthChange: !1,
//     // buttons: ["copy", "print"],

//     language: {
//       infoEmpty: "هیچ معلوماتی برای نمایش وجود ندارد! ",
//       paginate: {
//         previous: "<i class='fas fa-chevron-right'></i>",
//         next: "<i class='fas fa-chevron-left'></i>"
//       }
//     },

//   });


//   $(".dataTables_length select").addClass("form-select form-select-sm"), $(".dataTables_length label").addClass("form-label")
// });




$('.pr').click(function() {
    $('.togg').toggle();
    $('.togg').toggleClass('priv');
})


$('.ulpr').click(function() {
    $('.nstul').toggleClass('d-none');
})
$('.ulpr2').click(function() {
    $('.nstul2').toggleClass('d-none');
})
$('.ulpr3').click(function() {
    $('.nstul3').toggleClass('d-none');
})


$(".fadeout").fadeOut(4000, function() {
    $(".fadeout").addClass("d-none");
});


function frm(value, DivId) {

    var dot = '';
    var temp = '';
    if (value.includes(".")) {
        var total = value.split('.');
        value = total[0];
        dot = total[1];
        temp = '.';
    }

    value = value.replaceAll(",", "");
    var result = new Intl.NumberFormat().format(value) + temp + dot;

    console.log(result);

    $("#input1").val(result);

}



$(document).ready(function() {
    $("#nav-buy-tab").click(function() {
        $("#nav-sell-tab").removeClass("nav-tabs-dang");
        $("#nav-buy-tab").addClass("nav-tabs-succ");
    });
});

$(document).ready(function() {
    $("#nav-sell-tab").click(function() {
        $("#nav-sell-tab").addClass("nav-tabs-dang");
        $("#nav-buy-tab").removeClass("nav-tabs-succ");
    });
});



// $(document).ready(function() {

//     var select = $('select[multiple2]');
//     var options = select.find('option');

//     var div = $('<div />').addClass('selectMultiple2');
//     var active = $('<div />');
//     var list = $('<ul />');
//     var placeholder = select.data('placeholder');

//     var span = $('<span />').text(placeholder).appendTo(active);

//     options.each(function() {
//         var text = $(this).text();
//         if ($(this).is(':selected')) {
//             active.append($('<a />').html('<em>' + text + '</em><i></i>'));
//             span.addClass('hide');
//         } else {
//             list.append($('<li />').html(text));
//         }
//     });

//     active.append($('<div />').addClass('arrow'));
//     div.append(active).append(list);

//     select.wrap(div);

//     $(document).on('click', '.selectMultiple2 ul li', function(e) {
//         var select = $(this).parent().parent();
//         var li = $(this);
//         if (!select.hasClass('clicked')) {
//             select.addClass('clicked');
//             li.prev().addClass('beforeRemove');
//             li.next().addClass('afterRemove');
//             li.addClass('remove');
//             var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
//             a.slideDown(100, function() {
//                 setTimeout(function() {
//                     a.addClass('shown');
//                     select.children('div').children('span').addClass('hide');
//                     select.find('option:contains(' + li.text() + ')').prop('selected', true);
//                 }, 150);
//             });
//             setTimeout(function() {
//                 if (li.prev().is(':last-child')) {
//                     li.prev().removeClass('beforeRemove');
//                 }
//                 if (li.next().is(':first-child')) {
//                     li.next().removeClass('afterRemove');
//                 }
//                 setTimeout(function() {
//                     li.prev().removeClass('beforeRemove');
//                     li.next().removeClass('afterRemove');
//                 }, 100);

//                 li.slideUp(100, function() {
//                     li.remove();
//                     select.removeClass('clicked');
//                 });
//             }, 100);
//         }
//     });

//     $(document).on('click', '.selectMultiple2 > div a', function(e) {
//         var select = $(this).parent().parent();
//         var self = $(this);
//         self.removeClass().addClass('remove');
//         select.addClass('open');
//         setTimeout(function() {
//             self.addClass('disappear');
//             setTimeout(function() {
//                 self.animate({
//                     width: 0,
//                     height: 0,
//                     padding: 0,
//                     margin: 0
//                 }, 150, function() {
//                     var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
//                     li.slideDown(100, function() {
//                         li.addClass('show');
//                         setTimeout(function() {
//                             select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
//                             if (!select.find('option:selected').length) {
//                                 select.children('div').children('span').removeClass('hide');
//                             }
//                             li.removeClass();
//                         }, 100);
//                     });
//                     self.remove();
//                 })
//             }, 150);
//         }, 100);
//     });

//     $(document).on('click', '.selectMultiple2 > div .arrow, .selectMultiple2 > div span', function(e) {
//         $(this).parent().parent().toggleClass('open');
//     });

//   options.each(function() {
//       var text = $(this).text();
//       if($(this).is(':selected')) {
//           active.append($('<a />').html('<em>' + text + '</em><i></i>'));
//           span.addClass('hide');
//       } else {
//           list.append($('<li />').html(text));
//       }
//   });

//   active.append($('<div />').addClass('arrow'));
//   div.append(active).append(list);

//   select.wrap(div);

//   $(document).on('click', '.selectMultiple2 ul li', function(e) {
//       var select = $(this).parent().parent();
//       var li = $(this);
//       if(!select.hasClass('clicked')) {
//           select.addClass('clicked');
//           li.prev().addClass('beforeRemove');
//           li.next().addClass('afterRemove');
//           li.addClass('remove');
//           var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
//           a.slideDown(100, function() {
//               setTimeout(function() {
//                   a.addClass('shown');
//                   select.children('div').children('span').addClass('hide');
//                   select.find('option:contains(' + li.text() + ')').prop('selected', true);
//               }, 150);
//           });
//           setTimeout(function() {
//               if(li.prev().is(':last-child')) {
//                   li.prev().removeClass('beforeRemove');
//               }
//               if(li.next().is(':first-child')) {
//                   li.next().removeClass('afterRemove');
//               }
//               setTimeout(function() {
//                   li.prev().removeClass('beforeRemove');
//                   li.next().removeClass('afterRemove');
//               }, 100);

//               li.slideUp(100, function() {
//                   li.remove();
//                   select.removeClass('clicked');
//               });
//           }, 100);
//       }
//   });

// <<
// << << < HEAD
// var select = $('select[multiple]');
// var options = select.find('option');

// var div = $('<div />').addClass('selectMultiple');
// var active = $('<div />');
// var list = $('<ul />');
// var placeholder = select.data('placeholder');

// var span = $('<span />').text(placeholder).appendTo(active);

// options.each(function() {
//     var text = $(this).text();
//     if ($(this).is(':selected')) {
//         active.append($('<a />').html('<em>' + text + '</em><i></i>'));
//         span.addClass('hide');
//     } else {
//         list.append($('<li />').html(text));
//     }
// });

// active.append($('<div />').addClass('arrow'));
// div.append(active).append(list);

// select.wrap(div);

// $(document).on('click', '.selectMultiple ul li', function(e) {
//     var select = $(this).parent().parent();
//     var li = $(this);
//     if (!select.hasClass('clicked')) {
//         select.addClass('clicked');
//         li.prev().addClass('beforeRemove');
//         li.next().addClass('afterRemove');
//         li.addClass('remove');
//         var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
//         a.slideDown(100, function() {
//             setTimeout(function() {
//                 a.addClass('shown');
//                 select.children('div').children('span').addClass('hide');
//                 select.find('option:contains(' + li.text() + ')').prop('selected', true);
//             }, 150);
//         });
//         setTimeout(function() {
//             if (li.prev().is(':last-child')) {
//                 li.prev().removeClass('beforeRemove');
//             }
//             if (li.next().is(':first-child')) {
//                 li.next().removeClass('afterRemove');
//             }
//             setTimeout(function() {
//                 li.prev().removeClass('beforeRemove');
//                 li.next().removeClass('afterRemove');
//             }, 100);

//             li.slideUp(100, function() {
//                 li.remove();
//                 select.removeClass('clicked');
//             });
//         }, 100);
//     }
// });

// $(document).on('click', '.selectMultiple > div a', function(e) {
//     var select = $(this).parent().parent();
//     var self = $(this);
//     self.removeClass().addClass('remove');
//     select.addClass('open');
//     setTimeout(function() {
//         self.addClass('disappear');
//         setTimeout(function() {
//             self.animate({
//                 width: 0,
//                 height: 0,
//                 padding: 0,
//                 margin: 0
//             }, 150, function() {
//                 var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
//                 li.slideDown(100, function() {
//                     li.addClass('show');
//                     setTimeout(function() {
//                         select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
//                         if (!select.find('option:selected').length) {
//                             select.children('div').children('span').removeClass('hide');
//                         }
//                         li.removeClass();
//                     }, 100);
//                 });
//                 self.remove();
//             })
//         }, 150);
//     }, 100);
// });

// $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
//     $(this).parent().parent().toggleClass('open');
// }); ===
// ===
// =
//   $(document).on('click', '.selectMultiple2 > div a', function(e) {
//       var select = $(this).parent().parent();
//       var self = $(this);
//       self.removeClass().addClass('remove');
//       select.addClass('open');
//       setTimeout(function() {
//           self.addClass('disappear');
//           setTimeout(function() {
//               self.animate({
//                   width: 0,
//                   height: 0,
//                   padding: 0,
//                   margin: 0
//               }, 150, function() {
//                   var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
//                   li.slideDown(100, function() {
//                       li.addClass('show');
//                       setTimeout(function() {
//                           select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
//                           if(!select.find('option:selected').length) {
//                               select.children('div').children('span').removeClass('hide');
//                           }
//                           li.removeClass();
//                       }, 100);
//                   });
//                   self.remove();
//               })
//           }, 150);
//       }, 100);
//   });

//   $(document).on('click', '.selectMultiple2 > div .arrow, .selectMultiple2 > div span', function(e) {
//       $(this).parent().parent().toggleClass('open');
//   });

// });

// $(document).ready(function() {

//   var select = $('select[multiple]');
//   var options = select.find('option');

//   var div = $('<div />').addClass('selectMultiple');
//   var active = $('<div />');
//   var list = $('<ul />');
//   var placeholder = select.data('placeholder');

//   var span = $('<span />').text(placeholder).appendTo(active);

//   options.each(function() {
//       var text = $(this).text();
//       if($(this).is(':selected')) {
//           active.append($('<a />').html('<em>' + text + '</em><i></i>'));
//           span.addClass('hide');
//       } else {
//           list.append($('<li />').html(text));
//       }
//   });

//   active.append($('<div />').addClass('arrow'));
//   div.append(active).append(list);

//   select.wrap(div);

//   $(document).on('click', '.selectMultiple ul li', function(e) {
//       var select = $(this).parent().parent();
//       var li = $(this);
//       if(!select.hasClass('clicked')) {
//           select.addClass('clicked');
//           li.prev().addClass('beforeRemove');
//           li.next().addClass('afterRemove');
//           li.addClass('remove');
//           var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
//           a.slideDown(100, function() {
//               setTimeout(function() {
//                   a.addClass('shown');
//                   select.children('div').children('span').addClass('hide');
//                   select.find('option:contains(' + li.text() + ')').prop('selected', true);
//               }, 150);
//           });
//           setTimeout(function() {
//               if(li.prev().is(':last-child')) {
//                   li.prev().removeClass('beforeRemove');
//               }
//               if(li.next().is(':first-child')) {
//                   li.next().removeClass('afterRemove');
//               }
//               setTimeout(function() {
//                   li.prev().removeClass('beforeRemove');
//                   li.next().removeClass('afterRemove');
//               }, 100);

//               li.slideUp(100, function() {
//                   li.remove();
//                   select.removeClass('clicked');
//               });
//           }, 100);
//       }
//   });

//   $(document).on('click', '.selectMultiple > div a', function(e) {
//       var select = $(this).parent().parent();
//       var self = $(this);
//       self.removeClass().addClass('remove');
//       select.addClass('open');
//       setTimeout(function() {
//           self.addClass('disappear');
//           setTimeout(function() {
//               self.animate({
//                   width: 0,
//                   height: 0,
//                   padding: 0,
//                   margin: 0
//               }, 150, function() {
//                   var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
//                   li.slideDown(100, function() {
//                       li.addClass('show');
//                       setTimeout(function() {
//                           select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
//                           if(!select.find('option:selected').length) {
//                               select.children('div').children('span').removeClass('hide');
//                           }
//                           li.removeClass();
//                       }, 100);
//                   });
//                   self.remove();
//               })
//           }, 150);
//       }, 100);
//   });

//   $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
//       $(this).parent().parent().toggleClass('open');
//   });
// >>>
// >>>
// >
// f21f90f4476b6f6907727d4fa6c43b5052a58706

// });



function easyNumberSeparator(config) {
    // Currency Separator
    let commaCounter = 10;

    const obj = config ?
        config : {
            selector: ".num-f",
            separator: ",",
        };

    function numberSeparator(num) {
        for (let i = 0; i < commaCounter; i++) {
            num = num.replace(obj.separator, "");
        }

        x = num.split(".");
        y = x[0];
        z = x.length > 1 ? "." + x[1] : "";
        let rgx = /(\d+)(\d{3})/;

        while (rgx.test(y)) {
            y = y.replace(rgx, "$1" + obj.separator + "$2");
        }
        commaCounter++;

        const resInput = document.querySelector(obj.resultInput)
        if (resInput) {
            resInput.value = num.replace(obj.separator, "")
        }

        return y + z;
    }

    document.querySelectorAll(obj.selector).forEach(function(el) {
        el.addEventListener("input", function(e) {
            const reg = new RegExp(
                `^-?\\d*[${obj.separator}.]?(\\d{0,3}${obj.separator})*(\\d{3}${obj.separator})?\\d{0,3}$`
            );
            const key = e.data || this.value.substr(-1)

            if (reg.test(key)) {
                e.target.value = numberSeparator(e.target.value);
            } else {
                e.target.value = e.target.value.substring(0, e.target.value.length - 1);
                e.preventDefault();
                return false;
            }
        });
        el.value = numberSeparator(el.value);
    });
}

easyNumberSeparator({
    selector: '.num-f',
    separator: ',',
});


$(document).ready(function() {

    // place this within dom ready function
    function showpanel() {     
        $('html, body').animate({
            scrollTop: $('.scroll').offset().top
        }, 500);
        return false;
   }
  
   // use setTimeout() to execute
   setTimeout(showpanel, 1)
  
  });
