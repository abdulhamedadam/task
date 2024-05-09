<!--begin::Head-->
<title>@yield('title')</title>
<link rel="canonical" href="https://preview.keenthemes.com/keen"/>
{{--<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>--}}

<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css" integrity="sha512-NXUhxhkDgZYOMjaIgd89zF2w51Mub53Ru3zCNp5LTlEzMbNNAjTjDbpURYGS5Mop2cU4b7re1nOIucsVlrx9fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Add this line to include Noto Sans Arabic -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800;900&amp;family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">

{{--<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>

@if(app()->getLocale() =='ar')
{{--    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />--}}

    <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{asset('assets/css/custome/fonts.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/custome/extra.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
@else
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>

@endif
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&family=Tajawal:wght@500;700&display=swap" rel="stylesheet">
<style>
    h1 , h2 , h3 , h4 , h5 , h6 , p , div , ul , li a , input , button, label, span,option,th,tr,i {
        font-family: 'Cairo', sans-serif !important;
        line-height: 1.7;
    }
</style>
@if(session()->has('toastMessage'))
    <div id="kt_docs_toast_stack_container" class="toast-container position-fixed top-0 right-0 p-3 z-index-100" >
        <div id="toast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-kt-docs-toast="stack" style="padding-top: 5px; padding-bottom: 5px">
            <div class="toast-body" style="font-size: 16px; color: white; text-align: center">
                {{ session('toastMessage') }}
            </div>
            <div id="progressBar" class="progress" style="height: 2px" >
                <div class="progress-bar bg-success progress-bar-animated" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideInFromRight {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        @keyframes progressAnimation {
            0% {
                width: 100%;
            }
            100% {
                width: 0%;
            }
        }

        .toast {
            animation: slideInFromRight 0.5s forwards;
        }

        .progress-bar-animated {
            animation: progressAnimation 6s linear forwards;
        }
    </style>

    <script>
        // JavaScript function to display the toast message
        document.addEventListener('DOMContentLoaded', function() {
            // Select the toast container and toast element
            const container = document.getElementById('kt_docs_toast_stack_container');
            const toast = container.querySelector('.toast');

            // Display the toast message
            container.style.display = 'block';
            toast.classList.add('show');

            // Close the toast after a duration
            setTimeout(function() {
                toast.classList.remove('show');
                container.style.display = 'none';
            }, 6000); // Adjust the duration as needed
        });
    </script>
@endif








<style>

    .t_container{
        padding: 20px;
    }
    .custom-btn {
    width: 110px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    }

    .custom-btn .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    }

    .custom-btn .bi {
    margin-bottom: 5px; /* Adjust as needed */
    }
    .custom-btn .fas {
    font-size: 2em; /* Adjust the size as needed */
    }

    .span_data_table{
        padding: 2px !important;
        border-radius: 8px !important;
    }

    .span_label {
        color: black !important;
        font-weight: bold;
        text-decoration: underline;
        float: left !important;
    }

    .relay_class {
        color: #c7009a;
        font-weight: bold;
    }

    .timeline-body .icons {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        display: flex;
        align-items: center;
    }

    .timeline-body:hover .icons {
        opacity: 1;
    }

    .timeline-body .icons i {
        margin-left: 20px;
        margin-right: 10px;
    }
    .icon-container {
        display: inline-block;
        padding: 5px; /* Adjust padding as needed */
    }

    .bg-yellow {
        background-color: yellow;
    }


</style>




@yield('css')

