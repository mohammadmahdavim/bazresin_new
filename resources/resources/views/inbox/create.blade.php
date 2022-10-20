@extends('mail::layouts.master')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>
    <script>
        $(function() {


            // Plugins
            // ------------------------------

            // Summernote editor
            $('.summernote').summernote({
                height: 300,
                lang:'fa-IR',
            });


            // Related form components
            // ------------------------------

            // Styled checkboxes/radios
            $(".link-dialog input[type=checkbox], .note-modal-form input[type=radio]").uniform({
                radioClass: 'choice'
            });

            // Styled file input
            $(".note-image-input").uniform({
                fileButtonClass: 'action btn bg-warning-400'
            });

        });
    </script>



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Typeahead.js Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <!-- Typeahead Initialization -->
    <script>
        jQuery(document).ready(function($) {
            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/find?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'usersList',

                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<a href="' + data.profile.username + '" class="list-group-item">' + data.name + ' - @' + data.profile.username + '</a>'
                    }
                }
            });
        });
    </script>
@endsection

@section('contetn-warpper')
    <!-- Single mail -->
    <div class="panel panel-white">

        <!-- Mail toolbar -->
        <div class="panel-toolbar panel-toolbar-inbox">
            <div class="navbar navbar-default navbar-component no-margin-bottom">
                <ul class="nav navbar-nav visible-xs-block no-border">
                    <li>
                        <a class="text-center collapsed" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </li>
                </ul>

                <div class="navbar-collapse collapse" id="inbox-toolbar-toggle-single">
                    <div class="btn-group navbar-btn">
                        <button type="button" class="btn bg-blue"><i class="icon-arrow-right32 position-left"></i>ارسال پیام</button>
                    </div>

                    <div class="btn-group navbar-btn">
                        <button type="button" class="btn btn-default"><i class="icon-drawer3"></i> <span class="hidden-xs position-right">ذخیره در پیش نویس</span></button>
                        <button type="button" class="btn btn-default"><i class="icon-trash"></i> <span class="hidden-xs position-right">حذف پیام</span></button>
                    </div>

                    <div class="pull-right-lg">
                        <div class="btn-group navbar-btn">
                            <button type="button" class="btn btn-default"><i class="icon-printer"></i> <span class="hidden-xs position-right">چاپ</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /mail toolbar -->


        <!-- Mail details -->
        <div class="table-responsive mail-details-write">
            <table class="table">
                <tbody>
                <tr>
                    <td style="width: 150px">گیرنده:</td>
                    <td colspan="2" class="no-padding">
                        <form class="typeahead" role="search">
                            <div class="form-group" >
                                <input type="search" name="q" class="form-control search-input" autocomplete="off">
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>موضوع:</td>
                    <td class="no-padding"><input type="text" class="form-control" placeholder="موضوع نامه را درج نمایید..."></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <ul class="list-inline no-margin">
                            <li><a href="#"><i class="icon-attachment position-left"></i> افزودن فایل</a></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /mail details -->


        <!-- Mail container -->
        <div class="mail-container-write">
            <div class="summernote">
                سلام
            </div>
        </div>
        <!-- /mail container -->


        <!-- Attachments -->
        <div class="mail-attachments-container">
            <h6 class="mail-attachments-heading">فایل های افزوده شده</h6>

            <ul class="mail-attachments">
                <li>
								<span class="mail-attachments-preview">
									<i class="icon-file-pdf icon-2x"></i>
								</span>

                    <div class="mail-attachments-content">
                        <span class="text-semibold">new_december_offers.pdf</span>

                        <ul class="list-inline list-inline-condensed no-margin">
                            <li class="text-muted">174 KB</li>
                            <li><a href="#">View</a></li>
                            <li><a href="#">Remove</a></li>
                        </ul>
                    </div>
                </li>

                <li>
								<span class="mail-attachments-preview">
									<i class="icon-file-pdf icon-2x"></i>
								</span>

                    <div class="mail-attachments-content">
                        <span class="text-semibold">assignment_letter.pdf</span>

                        <ul class="list-inline list-inline-condensed no-margin">
                            <li class="text-muted">736 KB</li>
                            <li><a href="#">View</a></li>
                            <li><a href="#">Remove</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /attachments -->

    </div>
    <!-- /single mail -->
@stop
