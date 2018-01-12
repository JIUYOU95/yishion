/**
 * Created by Administrator on 2017/9/2.
 */
require.config({
    baseUrl: app.base + '/js',
    paths:{
        'css':'css.min',
        'jquery':'jquery.min',
        'angular':'angular.min',
        //angular分页
        'pagination':'pagination',
        'bootstrap':'../dist/bootstrap/js/bootstrap.min',
        //下拉菜单
        'select':'../dist/bootstrap-select/js/bootstrap-select',
        'select2':'../dist/select2/dist/js/i18n/zh-CN',
        'vselect2':'../dist/select2/dist/js/select2.min',
        'layui':'../dist/layui/layui',
        //文件图片上传控件
        'fileinput':'../dist/bootstrap-fileinput/js/locales/zh',
        //日期选择
        'datetimepicker':'../dist/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN',
        //时间区间
        'daterangepicker': '../dist/bootstrap-daterangepicker/daterangepicker.min',
        //时间处理 http://momentjs.cn/
        'moment': '../dist/bootstrap-daterangepicker/moment-with-locales.min',
        //函数库
        'underscore': '../js/underscore-min',
        //h5validate
        'validate':'../js/jquery.h5validate',
    },
    shim: {
        'hd': {
            // exports: 'modal',
            init: function () {
                return {
                    modal: modal,
                    success: success,
                }
            }
        },
        // bootstrap前端优化
        'bootstrap': {
            'deps': ['jquery', 'css!../dist/bootstrap/css/bootstrap.min.css', 'css!../dist/font-awesome/css/font-awesome.min.css','css!../css/app.css']
        },
        // bootstrap-select下拉组件
        'select':{
            'deps':['bootstrap','css!../dist/bootstrap-select/css/bootstrap-select.css']
        },
        // 下拉菜单
        'select2':{
            'deps':['bootstrap','vselect2','css!../dist/select2/dist/css/select2.min.css']
        },
        // layui组件
        'layui':{
            'deps':['css!../dist/layui/css/layui.css']
        },
        //日期选择
        'datetimepicker':{
            'deps':['jquery','bootstrap','css!../dist/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css','../../Public/vendor/dist/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js']
        },
        //时间区间
        'daterangepicker': {
            'deps': ['jquery', 'moment', 'bootstrap', 'css!../dist/bootstrap-daterangepicker/daterangepicker.min.css']
        },
        //上传控件
        'fileinput':{
            'deps':['css!../dist/bootstrap-fileinput/css/default.css','css!../dist/bootstrap-fileinput/css/fileinput.css','../../Public/vendor/dist/bootstrap-fileinput/js/fileinput.js']
        },
        //h5validate
        'validate':{
            'deps':['jquery']
        },
        // angular分页
        'pagination':{
            'deps':['angular']
        },
    }
});
