@extends('mail::layouts.master')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/core/libraries/jasny_bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/mail_list.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>
@endsection

@section('contetn-warpper')
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title"> صندوق ورودی</h6>

                <div class="heading-elements not-collapsible">
                    <span class="label bg-blue heading-text">پیام های امروز 12</span>
                </div>
            </div>

            <div class="panel-toolbar panel-toolbar-inbox">
                <div class="navbar navbar-default">
                    <ul class="nav navbar-nav visible-xs-block no-border">
                        <li>
                            <a class="text-center collapsed" data-toggle="collapse"
                               data-target="#inbox-toolbar-toggle-multiple">
                                <i class="icon-circle-down2"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="navbar-collapse collapse" id="inbox-toolbar-toggle-multiple">
                        <div class="btn-group navbar-btn">
                            <button type="button" class="btn btn-default btn-icon btn-checkbox-all">
                                <input type="checkbox" class="styled">
                            </button>

                            <button type="button" class="btn btn-default btn-icon dropdown-toggle"
                                    data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu">
                                <li><a href="#"> انتخاب همه </a></li>
                                <li><a href="#"> انتخاب خوانده شده</a></li>
                                <li><a href="#"> انتخاب خوانده نشده </a></li>
                                <li class="divider"></li>
                                <li><a href="#"> پاک کردن پیام های انتخاب شده</a></li>
                            </ul>
                        </div>

                        <div class="btn-group navbar-btn">
                            <button type="button" class="btn btn-default"><i class="icon-pencil7"></i> <span
                                    class="hidden-xs position-right">نوشتن</span></button>
                            <button type="button" class="btn btn-default"><i class="icon-bin"></i> <span
                                    class="hidden-xs position-right">حذف</span></button>
                        </div>

                        <div class="navbar-right">
                            <p class="navbar-text"><span class="text-semibold">1-50</span> of <span
                                    class="text-semibold">528</span></p>

                            <div class="btn-group navbar-left navbar-btn">
                                <button type="button" class="btn btn-default btn-icon disabled"><i
                                        class="icon-arrow-right13"></i></button>
                                <button type="button" class="btn btn-default btn-icon"><i class="icon-arrow-left12"></i>
                                </button>
                            </div>

                            <div class="btn-group navbar-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-cog3"></i>
                                    <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">One more line</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-inbox">
                    <tbody data-link="row" class="rowlink">
                    <tr class="unread">
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/spotify.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Spotify</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">On Tower-hill, as you go down</div>
                            <span class="table-inbox-preview">To the London docks, you may have seen a crippled beggar (or KEDGER, as the sailors say) holding a painted board before him, representing the tragic scene in which he lost his leg</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            11:09 pm
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
										<span class="btn bg-warning-400 btn-rounded btn-icon btn-xs">
											<span class="letter-icon"></span>
										</span>
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">James Alexander</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject"><span class="label bg-success position-left">Promo</span>
                                There are three whales and three boats
                            </div>
                            <span class="table-inbox-preview">And one of the boats (presumed to contain the missing leg in all its original integrity) is being crunched by the jaws of the foremost whale</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            10:21 pm
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-full2 text-warning-300"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/placeholder.jpg" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Nathan Jacobson</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">Any time these ten years, they tell me, has that man held
                                up
                            </div>
                            <span class="table-inbox-preview">That picture, and exhibited that stump to an incredulous world. But the time of his justification has now come. His three whales are as good whales as were ever published in Wapping, at any rate; and his stump</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            8:37 pm
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-full2 text-warning-300"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
										<span class="btn bg-indigo-400 btn-rounded btn-icon btn-xs">
											<span class="letter-icon"></span>
										</span>
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Margo Baker</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">Throughout the Pacific, and also in Nantucket, and New
                                Bedford
                            </div>
                            <span class="table-inbox-preview">and Sag Harbor, you will come across lively sketches of whales and whaling-scenes, graven by the fishermen themselves on Sperm Whale-teeth, or ladies' busks wrought out of the Right Whale-bone</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            4:28 am
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/dribbble.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Dribbble</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">The whalemen call the numerous little ingenious
                                contrivances
                            </div>
                            <span class="table-inbox-preview">They elaborately carve out of the rough material, in their hours of ocean leisure. Some of them have little boxes of dentistical-looking implements</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Dec 5
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
										<span class="btn bg-brown-400 btn-rounded btn-icon btn-xs">
											<span class="letter-icon"></span>
										</span>
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Hanna Dorman</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">Some of them have little boxes of dentistical-looking
                                implements
                            </div>
                            <span class="table-inbox-preview">Specially intended for the skrimshandering business. But, in general, they toil with their jack-knives alone; and, with that almost omnipotent tool of the sailor</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            Dec 5
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/twitter.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Twitter</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject"><span
                                    class="label bg-indigo-400 position-left">Order</span> Long exile from Christendom
                            </div>
                            <span class="table-inbox-preview">And civilization inevitably restores a man to that condition in which God placed him, i.e. what is called savagery</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Dec 4
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-full2 text-warning-300"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
										<span class="btn bg-pink-400 btn-rounded btn-icon btn-xs">
											<span class="letter-icon"></span>
										</span>
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Vanessa Aurelius</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">Your true whale-hunter is as much a savage as an Iroquois
                            </div>
                            <span class="table-inbox-preview">I myself am a savage, owning no allegiance but to the King of the Cannibals; and ready at any moment to rebel against him. Now, one of the peculiar characteristics of the savage in his domestic hours</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            Dec 4
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/placeholder.jpg" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">William Brenson</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">An ancient Hawaiian war-club or spear-paddle</div>
                            <span class="table-inbox-preview">In its full multiplicity and elaboration of carving, is as great a trophy of human perseverance as a Latin lexicon. For, with but a bit of broken sea-shell or a shark's tooth</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            Dec 4
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/facebook.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Facebook</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">As with the Hawaiian savage, so with the white
                                sailor-savage
                            </div>
                            <span class="table-inbox-preview">With the same marvellous patience, and with the same single shark's tooth, of his one poor jack-knife, he will carve you a bit of bone sculpture, not quite as workmanlike</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Dec 3
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-full2 text-warning-300"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/placeholder.jpg" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Vicky Barna</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject"><span class="label bg-pink-400 position-left">Track</span>
                                Achilles's shield
                            </div>
                            <span class="table-inbox-preview">Wooden whales, or whales cut in profile out of the small dark slabs of the noble South Sea war-wood, are frequently met with in the forecastles of American whalers. Some of them are done with much accuracy</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Dec 2
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/youtube.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Youtube</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">At some old gable-roofed country houses</div>
                            <span class="table-inbox-preview">You will see brass whales hung by the tail for knockers to the road-side door. When the porter is sleepy, the anvil-headed whale would be best. But these knocking whales are seldom remarkable as faithful essays</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            Nov 30
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/placeholder.jpg" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Tony Gurrano</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">On the spires of some old-fashioned churches</div>
                            <span class="table-inbox-preview">You will see sheet-iron whales placed there for weather-cocks; but they are so elevated, and besides that are to all intents and purposes so labelled with "HANDS OFF!" you cannot examine them</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Nov 28
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-empty3 text-muted"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
										<span class="btn bg-danger-400 btn-rounded btn-icon btn-xs">
											<span class="letter-icon"></span>
										</span>
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Barbara Walden</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">In bony, ribby regions of the earth</div>
                            <span class="table-inbox-preview">Where at the base of high broken cliffs masses of rock lie strewn in fantastic groupings upon the plain, you will often discover images as of the petrified forms</span>
                        </td>
                        <td class="table-inbox-attachment"></td>
                        <td class="table-inbox-time">
                            Nov 28
                        </td>
                    </tr>

                    <tr>
                        <td class="table-inbox-checkbox rowlink-skip">
                            <input type="checkbox" class="styled">
                        </td>
                        <td class="table-inbox-star rowlink-skip">
                            <a href="mail_read.html">
                                <i class="icon-star-full2 text-warning-300"></i>
                            </a>
                        </td>
                        <td class="table-inbox-image">
                            <img src="assets/images/brands/amazon.png" class="img-circle img-xs" alt="">
                        </td>
                        <td class="table-inbox-name">
                            <a href="#">
                                <div class="letter-icon-title text-default">Amazon</div>
                            </a>
                        </td>
                        <td class="table-inbox-message">
                            <div class="table-inbox-subject">Here and there from some lucky point of view</div>
                            <span class="table-inbox-preview">You will catch passing glimpses of the profiles of whales defined along the undulating ridges. But you must be a thorough whaleman, to see these sights; and not only that, but if you wish to return to such a sight again</span>
                        </td>
                        <td class="table-inbox-attachment">
                            <i class="icon-attachment text-muted"></i>
                        </td>
                        <td class="table-inbox-time">
                            Nov 27
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
@stop
