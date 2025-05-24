<div class="row">
    <div class="tab-pane fade in">
        <div class="col-md-10">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="colored-rounded-tab-general">
                    <div class="form-group">
                        <label class="control-label col-md-3">
                        </label>
                        <div class="col-md-12">
                            <div class="possibilities-form">
                               @foreach($model->answers as $key => $answer)
                                <div id="possibility-template" >
                                    <div class="row delete-content"
                                    style="margin-top: 20px;padding: 16px 11px;box-shadow: 0px 0px 3px 0px #3641503d;">
                                    <input type="hidden" class="answer-id" name="old_answers[{{ $answer->id }}][id]"  value="{{ $answer->id }}">

                                    <ul class="nav nav-tabs">
                                        @foreach (config('translatable.locales') as $code)
                                            <li class="@if($code == locale()) active @endif">
                                                <a data-toggle="tab" href="#{{ $answer->id }}_{{$code}}">
                                                    {{ optional(config('field.locales')[$code]) ? config('field.locales')[$code]['native'] : $code }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content">
                                    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
                                        id="{{ $answer->id }}_{{$code}}">
                                        {!! field()->text("old_answers[$answer->id][answer][$code]",
                                        __('exam::dashboard.answers.form.answer').'-'.$code , $answer->getTranslation('answer' , $code),
                                        ['data-name' => "old_answers.$answer->id.answer.$code"]
                                        ) !!}
                                        </div>
                                        @endforeach
                                    </div>

                                  {!! field()->number("old_answers[$answer->id][degree]", __('exam::dashboard.questions.form.degree'),$answer->degree??0) !!}


                                        <div class="col-xs-12">
                                            <span class="input-group-btn">
                                                <a data-input="images" data-preview="holder"
                                                   class="btn btn-danger delete-possibility">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>

                            <br>
                            <div class="form-group">
                                <button
                                    type="button"
                                    class="btn btn-sm green add-possibility"
                                    data-style="slide-down"
                                    data-spinner-color="#333">
                                    <i class="fa fa-plus-circle"></i>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>

        // member FORM / ADD NEW member
        $(document).ready(function () {
            var html =`<div id="possibility-template" >
                                <div class="row delete-content"
                                     style="margin-top: 20px;padding: 16px 11px;box-shadow: 0px 0px 3px 0px #3641503d;">
                                     <ul class="nav nav-tabs">
                                        @foreach (config('translatable.locales') as $code)
                                            <li class="@if($code == locale()) active @endif">
                                                <a data-toggle="tab" href="#::index_{{$code}}">
                                                    {{ optional(config('field.locales')[$code]) ? config('field.locales')[$code]['native'] : $code }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
                                         id="::index_{{$code}}">
                                            {!! field()->text('answers[::index][answer]['.$code.']',
                                            __('exam::dashboard.answers.form.answer').'-'.$code ,null,['data-name' => 'answers.::index.'.$code]
                                            ) !!}
                                        </div>
                               @endforeach
                              </div>

                                    {!! field()->number("answers[::index][degree]", __('exam::dashboard.questions.form.degree'),0) !!}

                                    <div class="col-xs-12">
                                        <span class="input-group-btn">
                                            <a data-input="images" data-preview="holder"
                                               class="btn btn-danger delete-possibility">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </span>
                                    </div>
                                </>
                            </div>`;




            $(".add-possibility").click(function (e) {
                e.preventDefault();
                var content = html;
                var rand = Math.floor(Math.random() * 9000000000) + 1000000000;
                content = replaceAll(content, '::index', rand);
                $(".possibilities-form").append(content);
                $('.make-switch').bootstrapSwitch();


            });
        });

        // DELETE member BUTTON
        $(".possibilities-form").on("click", ".delete-possibility", function (e) {
             e.preventDefault();
             const id= $(this).closest('.delete-content').find('.answer-id').val();
             if(id){
                 $('.possibilities-form').append(`<input type="hidden"  name="deletedAnswers[]"  value="${id}">`);
             }
            $(this).closest('.delete-content').remove();

        });

        function escapeRegExp(string) {
            return string.replace(/[.+?^${}()|[]\]/g, "\$&");
        }

        // Define functin to find and replace specified term with replacement string
        function replaceAll(str, term, replacement) {
            return str.replace(new RegExp(escapeRegExp(term), 'g'), replacement);
        }



    </script>
@endpush
