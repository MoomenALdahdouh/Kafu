@extends('layout.main')
@section('site_title','main')
@section('site_description','main')
@section('site_author','main')
@section('site_keywords','main')
@section('site_copyright','main')
@section('site_css')
@endsection
{{--TODO:: By Eng. Moomen Sameer Aldahdouh 0599124279, moomenaldahdouh@gmail.com--}}
<style>
    body {
        height: 100%;
        width: 100%;
        background-color: #1576ff !important;
        color: #FFF !important;
    }
</style>
@section('site_content')
    <div class="container-form my-5 mx-auto">
        <div class="w-100 text-center">
            <div class="">
                <img alt="email" style="object-fit: contain; width: auto; height: 40%"
                     src="https://cdn-icons-png.flaticon.com/128/6204/6204070.png">
                <h1>تم التحقق من الحساب بنجاح</h1>
                <br>
                <a href="{{url("subscriber/auth")}}" class="active btn btn-white login-text mx-3">تسجيل الدخول</a>
            </div>
        </div>
    </div>
@endsection
@section('site_js')

    <script>
        let submit_button = document.getElementById("submit_button"),
            add_form = $("#kt_form");

        $(document).ready(function () {
            console.log("sadsa")
            submit();
        });

        function submit() {
            errors_tags.addClass("d-none");
            $("#my_form").submit(function (e) {

                e.preventDefault();
                let action_url = e.currentTarget.action,
                    data = $(this).serializeArray();
                $.ajax({
                    url: action_url,
                    type: 'post',
                    dataType: 'application/json',
                    data: data,
                    success: function (response) {
                        let data = JSON.parse(response.responseText);
                        if ($.isEmptyObject(data.error)) {
                            success_submit();
                        } else {
                            failed_submit(data.error);
                        }
                    },
                    error: function (response) {
                        let data = JSON.parse(response.responseText);
                        if ($.isEmptyObject(data.error)) {
                            success_submit();
                        } else {
                            failed_submit(data.error);
                        }
                    }

                });

            });
        }

        function print_error(errors) {
            errors_tags.removeClass("d-none");
            let i = 0;
            $.each(errors, function (index, val) {
                if (i == 0) {
                    $("#" + index).focus();
                    i++;
                }
                $("#" + index + "_error").html(val);
            });
        }

        function success_submit() {
            errors_tags.html("");
            submit_button.disabled = !1;
            window.location.replace("{!! url("subscriber/account-confirm") !!}");
        }

        function failed_submit(errors) {
            errors_tags.html("");
            submit_button.disabled = !1
            print_error(errors);
        }
    </script>
@endsection
