define(['bootstrap'], function () {
    return {
        show: function () {
            alert('JIUYOU')
        },
        //日历选项
        datetimepicker: function (opt) {
            var options = $.extend({
                language: 'zh-CN',//中文
                format: 'yyyy-mm-dd hh:ii:ss',//格式
                autoclose:true,//选择日期后自动关闭
                todayBtn: true,//显示今天
            }, opt.options)
            require(['datetimepicker'], function () {
                    $(opt.element).datetimepicker(options);
                }
            );
        },
        //日期区间
        daterangepicker: function (opt) {
            var options = $.extend({
                "autoApply": true,//自动关闭,有timePicker属性时无效
                "locale": {
                    "format": "YYYY-MM-DD",//YYYY/MM/DD H:m
                    "separator": " 至 ",
                    "applyLabel": "确定",
                    "cancelLabel": "取消",
                    "fromLabel": "From",
                    "daysOfWeek": [
                        "日", "一", "二", "三", "四", "五", "六"
                    ],
                    "monthNames": [
                        "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
                    ],
                    "firstDay": 0
                },
            }, opt);

            require(['bootstrap','daterangepicker'], function () {
                    $(opt.element).daterangepicker(options, function (start, end, label) {
                        if (opt.callback) {
                            opt.callback(start, end, label)
                        }
                    });
                }
            )
        },
    }
    if (typeof define === "function" && define.amd) {
        define(['bootstrap'], function () {
            return util;
        });
    } else {
        window.util = util;
    }
});