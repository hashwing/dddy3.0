/**
 * Created by gg on 2016/11/25.
 */
var uid=null;
$(function(){
    login();
    $('#save').addClass("disabled");
    $('#myModal').modal({
        backdrop:'static',
        show:false
    });
    $('#jiesuan').modal({
        backdrop:'static',
        show:false
    });
    $('#print-setting').addClass('hidden');
    filelist();
    updataPrice();
    updatePrintAdr();
});
function updatePrintAdr(){
    $.ajax({
        type:"post",
        url:"../ajax_req/req_print.php",
        data:{},
        success:function(data){
            $('#print-adr').empty();
            $('#print-adr').append('<option value="0">-请选择打印地点-</option>');
            var obj=JSON.parse(data);
            $.each(obj,function(i,val){
                $('#print-adr').append('<option value="'+val['sid']+'" >'+val['ssq']+'-'+val['ssh']+'</option>');
            });

        }
    })
}
$('#print-adr').change(function(){
    var sid=$('#print-adr').val();
    $.ajax({
       type:"post",
        url:"../ajax_req/req_time_adr.php",
        data:{"sid":sid},
        success:function(data){
            var obj=JSON.parse(data);
            $('#get-time').empty();
            $('#send-time').empty();
            $('#send-adr').empty();
            $('#get-time').append('<option value="0">-请选择自提时间-</option>');
            $('#send-time').append('<option value="0">-请选择配送时间-</option>');
            $('#send-adr').append('<option value="0">-请选择配送宿舍区-</option>');
            $.each(obj.GetTime,function(i,val){
               $('#get-time').append('<option value="'+val['id']+'">'+val['time']+'</option>');
        });
            $.each(obj.SendTime,function(i,val){
                $('#send-time').append('<option value="'+val['id']+'">'+val['time']+'</option>');
            });
            $.each(obj.SendAdr,function(i,val){
                $('#send-adr').append('<option value="'+val['id']+'">'+val['adr']+'</option>');
            });
        }
    });
});
$('#isSend').change(function(){
    if($('#isSend').prop('checked')){
        $('.get-time').addClass('hidden');
        $('.send-time').removeClass('hidden');
        $('.send-info').removeClass('hidden');
    }else{
        $('.get-time').removeClass('hidden');
        $('.send-time').addClass('hidden');
        $('.send-info').addClass('hidden');
    }
});
function login(){
    $.ajax({
        post:"get",
        url:"../ajax_req/login.php",
        success:function(data){
            uid=data;
            new $.zui.Messager('欢迎来到云打印，我们倾心为您服务！', {
                type: 'success',
                icon: 'check',
                placement: 'bottom-right' // 定义显示位置
            }).show();

        }
    });
}

function uploadtoken(filetype){
    $.ajax({
        url:"../ajax_req/uploadtoken.php",
        type:"post",
        data:{"filetype":filetype},
        success:function(data){
            $('#token').val(data);
            if($('#token').val()!=''&&$('#token').val()!=null){
                upload();
            }
        }
    });
}
$('#addfile').click(function(){
    $("#file").click();
    $('.progress-bar').css('width','0%');
});
function upload(){
    var fd = new FormData();
    fd.append("file",$('#file')[0].files[0]);
    fd.append("token",$("#token").val());
    var xhr = new XMLHttpRequest();
    if ( xhr.upload ) {
        $('#myModal').modal('show');
        xhr.upload.onprogress = function(e) {
            var done = e.loaded || e.loaded, total = e.total || e.total;
            console.log('xhr.upload上传进度: ' + done + ' / ' + total + ' = ' + (Math.floor(done/total*1000)/10) + '%');
            var aaa=Math.floor(done/total*1000)/10+'%';
            $('.progress-value').html(aaa);
            $('.progress-bar').css('width',aaa);

        };
    }
    xhr.onreadystatechange = function(e) {
        if ( 4 == this.readyState ) {
            //alert('xhr upload complete')

            if (xhr.status == 200) {//200代表执行成功
            //alert(xhr.responseText);
                var obj=JSON.parse(xhr.responseText);
                var arrUrl=obj.key.split(".");
                var filename=arrUrl[0];
                $('#filename').val(filename+'.pdf');
                var key=filename+'.pdf';
                $('#filetip').html("正在转码中，请稍后……");
                $('#filetip').removeClass('hidden');
                $('#upload-state').addClass('hidden');
                //alert(obj.hash);
               //getpdf(obj.hash,key);
                setTimeout(function(){getpages(key)},5000);


            }
        }
    };
    xhr.open('post', 'http://up.qiniu.com?', true);
    xhr.send(fd);

}
function getpdf(hash,filename){
    $.ajax({
        type:"post",
        url:"../ajax_req/hash.php",
        data:{"hash":hash,"filename":filename},
        success:function(data){
            if(data!=''){
                setTimeout(function(){getpages(data)},5000);
            }
        }
    });
}
function  getpages(key){
    var url='http://ogzb58mxe.bkt.clouddn.com/'+key+'?odconv/jpg/info';
    var obj=new XMLHttpRequest();
    obj.open('GET',url,true);
    obj.onreadystatechange=function(){
        if(obj.readyState == 4 && obj.status ==404){
            setTimeout(function(){getpages(key)},2000);
        }else if (obj.readyState == 4 && obj.status == 200 || obj.status == 304) {
         {
            var obj1=JSON.parse(obj.responseText);
            if(obj1.page_num!=null){
                $('#range2').val(obj1.page_num);
                $('#filetip').addClass('hidden');
                $('#filedesc').removeClass('hidden');
                $('#save').removeClass("disabled");
                $('#print-setting').removeClass('hidden');
            }else {
                getpages(key);
            }
        }
    }
    };
    obj.send(null);
}
$("#file").change(function(){

    var url=$('#file').val();
    //var point=url.lastIndexOf(".");
    var arrUrl=url.split("/");
    var filename=arrUrl[arrUrl.length-1];
    $('#rfilename').val(filename);
     arrUrl=filename.split(".");
    var filetype=arrUrl[arrUrl.length-1];
    if(filetype=='pdf'||filetype=='doc'||filetype=='docx'){
        $('#myModal').modal('show');
        uploadtoken(filetype);
    }else {
        new $.zui.Messager('只支持pdf、doc、docx文档', {
            type: 'danger',
            icon: 'times',
            placement: 'center'
        }).show();
        $('#cancel').click();
    }



});
$('#cancel').click(function(){
    $('#file').val('');
    $('#filename').val('');
    $('#rfilename').val('');
    $('#pagetype').val('1');
    $('#range').val(1);
    $('#range2').val('');
    $('#copys').val(1);
    $('#upload-state').removeClass('hidden');
    $('#filedesc').addClass('hidden');
    $('#print-setting').addClass('hidden');
    $('#myModal').modal('hide');

});
$('#save').click(function(){
    $('#save').addClass("disabled");
    var filename=$('#filename').val();
    var refilename=$('#rfilename').val();
    var pagetype=$('#pagetype').val();
    var range=$('#range').val();
    var range2=$('#range2').val();
    var copys=$('#copys').val();
    var isbind=$('#isbind').val();
    if(range<=0||range2<=0||copys<=0)
    {
        new $.zui.Messager('打印范围或打印份数不能为0。', {
            type: 'danger',
            icon: 'times',
            placement: 'center'
        }).show();
        $('#save').removeClass("disabled");
        return false;
    }

    $.ajax({
       type:"post",
        url:"../ajax_req/addfile.php",
        data:{"filename":filename,"refilename":refilename,"pagetype":pagetype,
            "range":range,"range2":range2,"copys":copys,"isbind":isbind},
        success:function(data){
            if(data=='1'){
                filelist();
                $('#upload-state').removeClass('hidden');
                $('#filedesc').addClass('hidden');
                $('#print-setting').addClass('hidden');
                $('#file').val('');
                $('#filename').val('');
                $('#rfilename').val('');
                $('#pagetype').val('1');
                $('#range').val(1);
                $('#range2').val('');
                $('#copys').val(1);
                updataPrice();
                new $.zui.Messager('保存成功。', {
                    type: 'success',
                    icon: 'check',
                    placement: 'center'
                }).show();
                $('#myModal').modal('hide');

            }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            new $.zui.Messager('网络错误,请重试。', {
                type: 'danger',
                icon: 'times',
                placement: 'center'
            }).show();
            $('#save').removeClass("disabled");
        }
    });
    //
});

//
function  filelist(){
    $.ajax({
       type:"post",
        url:"../ajax_req/filelist.php",
        data:{"uid":uid},
        success:function(data){
            if(data!='0'){
                var dataObj=JSON.parse(data);
                var url='http://dcsapi.com/?k=36438353&url=http://ogzb58mxe.bkt.clouddn.com/';
                var $tab1=$("#file-list");
                $tab1.empty();
                var tr = $('<tr>');
                tr.append($('<td  style="text-align: center">').html("文件名"));
                tr.append($('<td class="hidden-xs" style="text-align: center">').html("单双面"));
                tr.append($('<td class="hidden-xs" style="text-align: center">').html("范围"));
                tr.append($('<td class="hidden-xs" style="text-align: center">').html("份数"));
                tr.append($('<td  style="text-align: center">').html("预览"));
                tr.append($('<td style="text-align: center">').html("删除"));
                $tab1.append(tr);
                $.each(dataObj,function(index,item){
                    var $tr = $('<tr>');
                    $tr.append($('<td>').html(item['wjm']));
                    var dsm=item['dsm']==1? '单面':'双面';
                    $tr.append($('<td class="hidden-xs">').html(dsm));
                    $tr.append($('<td class="hidden-xs">').html(item['sys']+'-'+item['mys']));
                    $tr.append($('<td class="hidden-xs">').html(item['fs']));
                    var PreButton='<button type="button" class="btn btn-primary btn-sm" data-size="lg" data-height="600" data-iframe="' +url+item['filename']+ '"data-toggle="modal">预览</button>'
                    $tr.append($('<td>').html(PreButton));
                    var DeleteButton='<a href="Javascript:delfile('+item['id']+')" style="color: red"><i class="icon icon-trash "></i></a>'
                    $tr.append($('<td>').html(DeleteButton));
                    $tab1.append($tr);
                });
            }else {
                $("#file-list").html('没有文件，请点上传');
            }


        }
    });
}

function delfile(id){
    $.ajax({
        type:"post",
        url:"../ajax_req/delfile.php" ,
        data:{"id":id},
        success:function(data){
            if(data!=0){
                filelist();
                updataPrice();
                new $.zui.Messager('删除成功!', {
                    type: 'success',
                    icon: 'check',
                    placement: 'center'
                }).show();
            }
        }
    });
}

function  updataPrice(){
    var sid=$('#print-adr').val();
    $.ajax({
       type:"post",
        url:"../ajax_req/price.php",
        data:{"sid":sid},
        success:function(data){
            var obj=JSON.parse(data);
            $('#single-price').html(obj.SinglePrice);
            $('#single-count').html(obj.SinglePages);
            $('#single-prices').html(obj.SinglePrices);
            $('#double-price').html(obj.DoublePrice);
            $('#double-count').html(obj.DoublePages);
            $('#double-prices').html(obj.DoublePrices);
            $('#All-price').html(obj.total)
        }
    });

}
$('.add-order').click(function(){
    var sid=$('#print-adr').val();
    var sh=$('#isSend').prop('checked')? 1:0;
    var gettime=$("#get-time").val();
    var sendtime=$("#send-time").val();
    var phone=$("#phone").val();
    var sendadr=$('#send-adr').val();
    var sendssh=$('#send-ssh').val();
    $.ajax({
       type:"post",
        url:"../ajax_req/order.php",
        data:{"sid":sid,"sh":sh,"gettime":gettime,"sendtime":sendtime,"phone":phone,"sendadr":sendadr,"sendssh":sendssh},
        success:function(data){
            if(data!=0){
                var obj=JSON.parse(data);
                $('#ddh').val(obj.ddh);
                $('#spxq').val(obj.count+'份文档打印');
                $('#zongjia').val(obj.total);
                $('#wds').html(obj.count);
                $('#zfprice').html(obj.total);
                $('#jiesuan').modal('show');
            }
            //$('#jiesuan').modal('show');
        }
    });

});