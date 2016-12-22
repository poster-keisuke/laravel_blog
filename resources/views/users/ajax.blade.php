@extends('layouts.app')
@section('content')

    <h1>一覧表示（API経由) page={{$page}}</h1>

    <table class="table table-striped" id="table">
    </table>

    <!-- pagenate -->
    <ul class="pagination" id="pagination">
    </ul>


@stop

@section('script')

    $(function(){

        //phpから現在のページを受け取る
        var page = {{$page}};

        $.getJSON('/json?page={{$page}}',null,function(json){

            //グローバルパラメータ取得
            var next_page_url = json.next_page_url;
            var prev_page_url = json.prev_page_url;
            var last_page = json.last_page;

            //使わないけど試しに取得しておく
            var total = json.total;
            var per_page = json.per_page;
            var current_page = json.current_page;

            // alert(next_page_url);

            //テーブルを描画
            for(row in json.data)
            {
                var id = json.data[row].id;
                var name = json.data[row].name;
                var email = json.data[row].email;

                $("#table").append("<tr>\
                    <td>"+id+"</td>\
                    <td>"+name+"</td>\
                    <td>"+email+"</td>\
                </tr>");
            }

            //ページネーターを描画

            //Prev 制御
            if(prev_page_url == null){
                $("#pagination").append("<li class='disabled'><a href=''>«</a></li>");
            }else{
                $("#pagination").append("<li><a href='/ajax?page="+(page-1)+"'>«</a></li>");
            }

            //ページリンク
            for(var i=0;i<last_page;i++)
            {
                var link_page = i+1;

                //activeにするかどうか
                if(page==link_page)
                {
                    $("#pagination").append("<li class='active'><a href='/ajax?page="+link_page+"'>"+link_page+"</a></li>");
                }else{
                    $("#pagination").append("<li><a href='/ajax?page="+link_page+"'>"+link_page+"</a></li>");
                }   
            }

            //Next制御
            if(next_page_url == null){
                $("#pagination").append("<li class='disabled'><a href=''>»</a></li>");
            }else{
                $("#pagination").append("<li><a href='/ajax?page="+(page+1)+"'>»</a></li>");
            }

        });

    });

@stop