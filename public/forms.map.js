function SendOffersEnd(){if(!$(this).is(".no-rules")){var o=0;$(".offers-form-k .gloab").each(function(e,s){""==$(this).val()?($(this).parents(".input_2018").find(".error-message").empty().append("поле не заполнено"),$(this).parents(".input_2018").addClass("required_in_2018"),o++):$(this).parents(".input_2018").removeClass("required_in_2018")}),0==o?($(".offers-form-k .js-offers-send-end").hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 15px; top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>'),AjaxClient("tender","offers","POST",0,"AfterSendOffersEnd",0,"offers-form-k")):ErrorBut(".offers-form-k .js-offers-send-end","Ошибка заполнения!")}}function AfterSendOffersEnd(e,s){"ok"==e.status?($(".offers-form-k").after('<span class="help-message"><strong>Ваша заявка на участие в закупке принята!</strong><br> После проверки заявки нашими специалистами, Вы сможетe принимать участие в аукционе по данной закупке.</span><div class="yes" style="margin-left: 0px;margin-top: 30px;">q</div>'),$(".offers-form-k").remove(),$(".js-new-offers").slideUp("slow")):($(".offers-form-k .js-offers-send-end").show(),$(".offers-form-k .b_loading_small").remove(),ErrorBut(".offers-form-k .js-offers-send-end","Ошибка!"))}function CostOffers(){var e=parseFloat($(this).val().replace(/\s/g,""));if(isNaN(e))$(".tender-offers-itog").slideUp("slow",function(){$(this).find(".js-no-nds, .js-s-nds, .js-nds").empty().append("0")});else{if($(this).is(".js-nds"))var s=e.toFixed(2),o=(e-(n=(e/1.2*.2).toFixed(2))).toFixed(2);if($(this).is(".js-nonds"))var n=((s=(1.2*(o=e.toFixed(2))).toFixed(2))-o).toFixed(2);$(".js-no-nds").empty().append($.number(o,2,"."," ")),$(".js-s-nds").empty().append($.number(s,2,"."," ")),$(".js-nds").empty().append($.number(n,2,"."," ")),$(".tender-offers-itog").slideDown("slow")}}function EnterLogin(e){13==e.which&&LoginYes()}function RecoverLogin(){var o=0;$(".js-form-open .gloab1").each(function(e,s){""==$(this).val()?($(this).parents(".input_2018").find(".error-message").empty().append("поле не заполнено"),$(this).parents(".input_2018").addClass("required_in_2018"),o++):$(this).parents(".input_2018").removeClass("required_in_2018")}),0==o?($(".js-form-open .js-recover-password").hide(),$(".js-form-open .js-log").hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>'),AjaxClient("open","recover","POST",0,"AfterRecoverLogin",0,"login-form-k")):$(".js-form-open .message-form").hide()}function AfterRecoverLogin(e,s){if($(".js-form-open .message-form").empty(),"reload"==e.status&&autoReload(),"ok"==e.status){var o=$(".js-form-open .js-in1").val();$(".js-form-open").empty().append('<span class="help-message">Проверьте свою электронную почту. Мы отправили письмо на электронный адрес <strong>'+o+'.</strong> Перейдите по ссылке в письме для сброса пароля.<br><br>Если письма нет во входящих, то попробуйте найти его в других папках (например, «Спам», «Социальные сети» или другие).</span><div class="yes">q</div>')}if("login_error"==e.status){var n=$(".js-form-open .js-in1").parents(".input_2018");$(".js-form-open .js-log").show(),$(".js-form-open .b_loading_small").remove(),n.addClass("required_in_2018"),n.find(".error-message").empty().append("поле заполнено неверно"),$(".js-form-open .js-recover-password").show()}"enabled"==e.status&&($(".js-form-open .message-form").empty().append("«Ошибка! Ваш личный кабинет заблокирован»").show(),$(".js-form-open .b_loading_small").remove(),$(".js-form-open .js-log").show(),$(".js-form-open .js-recover-password").show()),"no_active_email"==e.status&&($(".js-form-open .message-form").empty().append("<div>«Ошибка! Ваша электронная почта не подтверждена»<br>Невозможно напомнить пароль</div>").show(),$(".js-form-open .b_loading_small").remove(),$(".js-form-open .js-log").show())}function LoginYes(){if(!$(".js-form-open .js-log").is(".clock")){var o=0;$(".js-form-open .gloab").each(function(e,s){""==$(this).val()?($(this).parents(".input_2018").find(".error-message").empty().append("поле не заполнено"),$(this).parents(".input_2018").addClass("required_in_2018"),o++):$(this).parents(".input_2018").removeClass("required_in_2018")}),0==o?($(".js-form-open .js-log").hide().after('<div class="b_loading_small" style="position:relative; width: 40px;padding-top: 7px;top: auto;right: auto;left: calc(50% - 20px);"><div class="b_loading_circle_wrapper_small"><div class="b_loading_circle_one_small"></div><div class="b_loading_circle_one_small b_loading_circle_delayed_small"></div></div></div>'),$(".js-form-open .message-form").hide(),AjaxClient("open","open","POST",0,"AfterLoginYes",0,"login-form-k")):ErrorBut(".js-form-open .js-log","Ошибка заполнения!")}}function AfterLoginYes(e,s){if("reload"!=e.status&&"ok"!=e.status||autoReload(),"enabled"==e.status&&($(".js-form-open .message-form").empty().append("«Ошибка! Ваш личный кабинет заблокирован»").show(),$(".js-form-open .b_loading_small").remove(),$(".js-form-open .js-log").show()),"no_active_email"==e.status&&($(".js-form-open .message-form").empty().append('<div>«Ошибка! Ваша электронная почта не подтверждена»</div><div class="activate_mail_link js-active-link"><span>отправить письмо для активации</span></div>').show(),$(".js-form-open .b_loading_small").remove(),$(".js-form-open .js-log").show()),"time_limit"==e.status&&($(".js-form-open .message-form").empty().append("«Слишком много неуспешных попыток авторизации. Необходимо подождать "+e.echo+"»").show(),$(".js-form-open .b_loading_small").remove(),$(".js-form-open .js-log").addClass("clock").show(),initializeTimerLogin(e.echo1)),"login_error"==e.status){var o=$(".js-form-open .js-in1").parents(".input_2018");$(".js-form-open .js-log").show(),$(".js-form-open .b_loading_small").remove(),o.addClass("required_in_2018"),o.find(".error-message").empty().append("поле заполнено неверно")}if("password_error"==e.status){o=$(".js-form-open .js-in2").parents(".input_2018");$(".js-form-open .js-log").show(),$(".js-form-open .b_loading_small").remove(),o.addClass("required_in_2018"),o.find(".error-message").empty().append("поле заполнено неверно")}if("password_login"==e.status){o=$(".js-form-open .gloab").parents(".input_2018");$(".js-form-open .js-log").show(),$(".js-form-open .b_loading_small").remove(),o.addClass("required_in_2018"),o.find(".error-message").empty().append("неверный e-mail или пароль")}}$(function(){$(".box-modal").on("change keyup input click",".js-log",LoginYes),$(".box-modal").on("change keyup input click",".js-recover-password",RecoverLogin),$(".box-modal").on("keypress",".js-form-open .gloab",EnterLogin),$(".box-modal").on("change keyup input click",".js-cost-offers-c",CostOffers),$(".box-modal").on("change keyup input click",".js-offers-send-end",SendOffersEnd)});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImZvcm1zLmpzIl0sIm5hbWVzIjpbIlNlbmRPZmZlcnNFbmQiLCIkIiwidGhpcyIsImlzIiwiZXJyIiwiZWFjaCIsImkiLCJlbGVtIiwidmFsIiwicGFyZW50cyIsImZpbmQiLCJlbXB0eSIsImFwcGVuZCIsImFkZENsYXNzIiwicmVtb3ZlQ2xhc3MiLCJoaWRlIiwiYWZ0ZXIiLCJBamF4Q2xpZW50IiwiRXJyb3JCdXQiLCJBZnRlclNlbmRPZmZlcnNFbmQiLCJkYXRhIiwidXBkYXRlIiwic3RhdHVzIiwicmVtb3ZlIiwic2xpZGVVcCIsInNob3ciLCJDb3N0T2ZmZXJzIiwiY29zdCIsInBhcnNlRmxvYXQiLCJyZXBsYWNlIiwiaXNOYU4iLCJzX25kcyIsInRvRml4ZWQiLCJub19uZHMiLCJuZCIsIm51bWJlciIsInNsaWRlRG93biIsIkVudGVyTG9naW4iLCJlIiwid2hpY2giLCJMb2dpblllcyIsIlJlY292ZXJMb2dpbiIsIkFmdGVyUmVjb3ZlckxvZ2luIiwiYXV0b1JlbG9hZCIsIm1haWxfbmFtZSIsImhvb3AiLCJBZnRlckxvZ2luWWVzIiwiZWNobyIsImluaXRpYWxpemVUaW1lckxvZ2luIiwiZWNobzEiLCJvbiJdLCJtYXBwaW5ncyI6IkFBdUJBLFNBQUFBLGdCQUdBLElBQUFDLEVBQUFDLE1BQUFDLEdBQUEsYUFDQSxDQUVBLElBQUFDLEVBQUEsRUFDQUgsRUFBQSx5QkFBQUksS0FBQSxTQUFBQyxFQUFBQyxHQUNBLElBQUFOLEVBQUFDLE1BQUFNLE9BQUFQLEVBQUFDLE1BQUFPLFFBQUEsZUFBQUMsS0FBQSxrQkFBQUMsUUFBQUMsT0FBQSxxQkFBQVgsRUFBQUMsTUFBQU8sUUFBQSxlQUFBSSxTQUFBLG9CQUFBVCxLQUFBSCxFQUFBQyxNQUFBTyxRQUFBLGVBQUFLLFlBQUEsc0JBT0EsR0FBQVYsR0FHQUgsRUFBQSxzQ0FBQWMsT0FBQUMsTUFBQSw0VEFJQUMsV0FBQSxTQUFBLFNBQUEsT0FBQSxFQUFBLHFCQUFBLEVBQUEsa0JBSUFDLFNBQUEs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QixFQUFBLGtDQUFBc0IsU0FDQXNCLEVBQUFoQyxTQUFBLG9CQUNBZ0MsRUFBQW5DLEtBQUEsa0JBQUFDLFFBQUFDLE9BQUEsMEJBR0EsR0FBQSxrQkFBQVEsRUFBQUUsT0FDQSxDQUNBdUIsRUFBQTVDLEVBQUEsd0JBQUFRLFFBQUEsZUFDQVIsRUFBQSx5QkFBQXdCLE9BQ0F4QixFQUFBLGtDQUFBc0IsU0FDQXNCLEVBQUFoQyxTQUFBLG9CQUNBZ0MsRUFBQW5DLEtBQUEsa0JBQUFDLFFBQUFDLE9BQUEsK0JBclNBWCxFQUFBLFdBRUFBLEVBQUEsY0FBQWlELEdBQUEsMkJBQUEsVUFBQVYsVUFFQXZDLEVBQUEsY0FBQWlELEdBQUEsMkJBQUEsdUJBQUFULGNBR0F4QyxFQUFBLGNBQUFpRCxHQUFBLFdBQUEsdUJBQUFiLFlBR0FwQyxFQUFBLGNBQUFpRCxHQUFBLDJCQUFBLG9CQUFBeEIsWUFHQXpCLEVBQUEsY0FBQWlELEdBQUEsMkJBQUEsc0JBQUFsRCIsImZpbGUiOiJmb3Jtcy5tYXAuanMiLCJzb3VyY2VzQ29udGVudCI6WyJcclxuXHJcbiQoZnVuY3Rpb24gKCl7XHJcblx0Ly/QstC+0LnRgtC4XHJcblx0JCgnLmJveC1tb2RhbCcpLm9uKFwiY2hhbmdlIGtleXVwIGlucHV0IGNsaWNrXCIsXCIuanMtbG9nXCIsTG9naW5ZZXMpO1x0XHJcblx0Ly/QstC+0YHRgdGC0LDQvdC+0LLQuNGC0YxcclxuXHQkKCcuYm94LW1vZGFsJykub24oXCJjaGFuZ2Uga2V5dXAgaW5wdXQgY2xpY2tcIixcIi5qcy1yZWNvdmVyLXBhc3N3b3JkXCIsUmVjb3ZlckxvZ2luKTtcclxuXHRcclxuXHQvL9C90LDRiNCw0YLQuNC1IGVudGVyINC/0YDQuCDQstGF0L7QtNC1INCyINC/0L7Qu9C1INC70L7Qs9C40L0g0LjQu9C4INC/0LDRgNC+0LvRjFxyXG4gICAgJCgnLmJveC1tb2RhbCcpLm9uKFwia2V5cHJlc3NcIiwnLmpzLWZvcm0tb3BlbiAuZ2xvYWInLEVudGVyTG9naW4pO1x0XHJcblx0XHJcblx0Ly/Qv9C+0LTRgdGH0LXRgiDQvdC00YEg0L/RgNC4INCy0LLQvtC00LUg0YHRgtC+0LjQvNC+0YHRgtC4INCyINC30LDRj9Cy0LrQtVxyXG5cdCQoJy5ib3gtbW9kYWwnKS5vbihcImNoYW5nZSBrZXl1cCBpbnB1dCBjbGlja1wiLFwiLmpzLWNvc3Qtb2ZmZXJzLWNcIixDb3N0T2ZmZXJzKTtcclxuXHRcclxuXHQvL9C+0YLQv9GA0LDQstC40YLRjCDQt9Cw0Y/QstC60YMg0L/QvtGB0LvQtSDQstGB0LXRhSDQt9Cw0L/QvtC70L3QtdC90LjQuVxyXG5cdCQoJy5ib3gtbW9kYWwnKS5vbihcImNoYW5nZSBrZXl1cCBpbnB1dCBjbGlja1wiLFwiLmpzLW9mZmVycy1zZW5kLWVuZFwiLFNlbmRPZmZlcnNFbmQpO1xyXG5cdFxyXG5cdFxyXG59KTtcclxuXHJcbi8v0L7RgtC/0YDQsNCy0LjRgtGMINC30LDRj9Cy0LrRgyDQv9C+0YHQu9C1INCy0YHQtdGFINC30LDQv9C+0LvQvdC10L3QuNC5XHJcbi8vICB8XHJcbi8vIFxcL1xyXG5mdW5jdGlvbiBTZW5kT2ZmZXJzRW5kKClcclxue1xyXG5cdFxyXG5cdGlmKCEkKHRoaXMpLmlzKCcubm8tcnVsZXMnKSlcclxuXHRcdHtcclxuXHRcclxuXHR2YXIgZXJyID0gMDtcclxuXHQkKCcub2ZmZXJzLWZvcm0tayAuZ2xvYWInKS5lYWNoKGZ1bmN0aW9uKGksZWxlbSkge1xyXG5cdGlmKCQodGhpcykudmFsKCkgPT0gJycpICB7JCh0aGlzKS5wYXJlbnRzKCcuaW5wdXRfMjAxOCcpLmZpbmQoJy5lcnJvci1tZXNzYWdlJykuZW1wdHkoKS5hcHBlbmQoJ9C/0L7Qu9C1INC90LUg0LfQsNC/0L7Qu9C90LXQvdC+Jyk7XHQgJCh0aGlzKS5wYXJlbnRzKCcuaW5wdXRfMjAxOCcpLmFkZENsYXNzKCdyZXF1aXJlZF9pbl8yMDE4Jyk7IGVycisrOyB9IGVsc2UgeyQodGhpcykucGFyZW50cygnLmlucHV0XzIwMTgnKS5yZW1vdmVDbGFzcygncmVxdWlyZWRfaW5fMjAxOCcpO31cdFx0XHJcbn0pO1xyXG5cdFx0XHJcblx0XHJcblxyXG5cdFxyXG5cdFxyXG5cdGlmKGVycj09MClcclxuXHRcdHtcclxuXHRcdFx0XHJcblx0XHRcdCQoJy5vZmZlcnMtZm9ybS1rIC5qcy1vZmZlcnMtc2VuZC1lbmQnKS5oaWRlKCkuYWZ0ZXIoJzxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfc21hbGxcIiBzdHlsZT1cInBvc2l0aW9uOnJlbGF0aXZlOyB3aWR0aDogNDBweDtwYWRkaW5nLXRvcDogMTVweDsgdG9wOiBhdXRvO3JpZ2h0OiBhdXRvO2xlZnQ6IGNhbGMoNTAlIC0gMjBweCk7XCI+PGRpdiBjbGFzcz1cImJfbG9hZGluZ19jaXJjbGVfd3JhcHBlcl9zbWFsbFwiPjxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfY2lyY2xlX29uZV9zbWFsbFwiPjwvZGl2PjxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfY2lyY2xlX29uZV9zbWFsbCBiX2xvYWRpbmdfY2lyY2xlX2RlbGF5ZWRfc21hbGxcIj48L2Rpdj48L2Rpdj48L2Rpdj4nKTtcclxuXHRcdFx0XHJcblx0XHRcdFxyXG5cdFx0XHRcclxuXHRcdEFqYXhDbGllbnQoJ3RlbmRlcicsJ29mZmVycycsJ1BPU1QnLDAsJ0FmdGVyU2VuZE9mZmVyc0VuZCcsMCwnb2ZmZXJzLWZvcm0taycpO1x0XHJcblx0XHRcdFxyXG5cdFx0fSBlbHNlXHJcblx0XHRcdHtcclxuXHRcdFx0XHRFcnJvckJ1dCgnLm9mZmVycy1mb3JtLWsgLmpzLW9mZmVycy1zZW5kLWVuZCcsJ9Ce0YjQuNCx0LrQsCDQt9Cw0L/QvtC70L3QtdC90LjRjyEnKTtcclxuXHRcdFx0fVxyXG5cdFx0fVxyXG59XHJcblxyXG5cclxuZnVuY3Rpb24gQWZ0ZXJTZW5kT2ZmZXJzRW5kKGRhdGEsdXBkYXRlKVxyXG57XHJcblx0aWYgKGRhdGEuc3RhdHVzPT0nb2snKVxyXG4gICAge1xyXG5cdCAgICAkKCcub2ZmZXJzLWZvcm0taycpLmFmdGVyKCc8c3BhbiBjbGFzcz1cImhlbHAtbWVzc2FnZVwiPjxzdHJvbmc+0JLQsNGI0LAg0LfQsNGP0LLQutCwINC90LAg0YPRh9Cw0YHRgtC40LUg0LIg0LfQsNC60YPQv9C60LUg0L/RgNC40L3Rj9GC0LAhPC9zdHJvbmc+PGJyPiDQn9C+0YHQu9C1INC/0YDQvtCy0LXRgNC60Lgg0LfQsNGP0LLQutC4INC90LDRiNC40LzQuCDRgdC/0LXRhtC40LDQu9C40YHRgtCw0LzQuCwg0JLRiyDRgdC80L7QttC10YJlINC/0YDQuNC90LjQvNCw0YLRjCDRg9GH0LDRgdGC0LjQtSDQsiDQsNGD0LrRhtC40L7QvdC1INC/0L4g0LTQsNC90L3QvtC5INC30LDQutGD0L/QutC1Ljwvc3Bhbj48ZGl2IGNsYXNzPVwieWVzXCIgc3R5bGU9XCJtYXJnaW4tbGVmdDogMHB4O21hcmdpbi10b3A6IDMwcHg7XCI+cTwvZGl2PicpO1xyXG5cdFx0XHJcblx0XHQkKCcub2ZmZXJzLWZvcm0taycpLnJlbW92ZSgpO1xyXG5cdFx0JCgnLmpzLW5ldy1vZmZlcnMnKS5zbGlkZVVwKFwic2xvd1wiKTtcclxuXHRcdFxyXG5cdFx0XHJcblx0fSBlbHNlXHJcblx0e1xyXG5cdCBcdCAgJCgnLm9mZmVycy1mb3JtLWsgLmpzLW9mZmVycy1zZW5kLWVuZCcpLnNob3coKTtcclxuXHRcdCAgJCgnLm9mZmVycy1mb3JtLWsgLmJfbG9hZGluZ19zbWFsbCcpLnJlbW92ZSgpO1x0XHRcdFxyXG5cdFx0ICBFcnJvckJ1dCgnLm9mZmVycy1mb3JtLWsgLmpzLW9mZmVycy1zZW5kLWVuZCcsJ9Ce0YjQuNCx0LrQsCEnKTtcdFxyXG5cdH1cclxufVxyXG5cclxuLy/Qv9C+0LTRgdGH0LXRgiDQvdC00YEg0L/RgNC4INCy0LLQvtC00LUg0YHRgtC+0LjQvNC+0YHRgtC4INCyINC30LDRj9Cy0LrQtVxyXG4vLyAgfFxyXG4vLyBcXC9cclxuZnVuY3Rpb24gQ29zdE9mZmVycygpXHJcbntcclxuXHR2YXIgY29zdD1wYXJzZUZsb2F0KCQodGhpcykudmFsKCkucmVwbGFjZSgvXFxzL2csICcnKSk7XHJcblx0Ly9kZWJ1Zyhjb3N0LDApO1xyXG5cdGlmKCFpc05hTihjb3N0KSlcclxuXHRcdHtcclxuXHRpZiAoJCh0aGlzKS5pcygnLmpzLW5kcycpKSB7XHJcblx0ICAvL9GG0LXQvdCwINCy0LLQvtC00LjQu9Cw0YHRjCDRgSDQvdC00YFcclxuXHRcdHZhciBzX25kcz1jb3N0LnRvRml4ZWQoMik7XHJcblx0XHR2YXIgbmQgPSAoY29zdCAvIDEuMjAgKiAwLjIwKS50b0ZpeGVkKDIpO1xyXG5cdFx0dmFyIG5vX25kcyA9IChjb3N0IC0gbmQpLnRvRml4ZWQoMik7XHJcblxyXG5cdH1cclxuXHRpZiAoJCh0aGlzKS5pcygnLmpzLW5vbmRzJykpIHtcclxuXHQgIC8v0YbQtdC90LAg0LLQstC+0LTQuNC70LDRgdGMINCx0LXQtyDQvdC00YFcclxuXHRcdHZhciBub19uZHMgPSBjb3N0LnRvRml4ZWQoMik7XHJcblx0XHR2YXIgc19uZHM9KG5vX25kcyoxLjIpLnRvRml4ZWQoMik7XHJcblx0XHR2YXIgbmQgPSAoc19uZHMtbm9fbmRzKS50b0ZpeGVkKDIpO1xyXG5cclxuXHR9XHJcblx0XHRcdFxyXG5cdCQoJy5qcy1uby1uZHMnKS5lbXB0eSgpLmFwcGVuZCgkLm51bWJlcihub19uZHMsIDIsICcuJywgJyAnKSk7XHRcclxuXHQkKCcuanMtcy1uZHMnKS5lbXB0eSgpLmFwcGVuZCgkLm51bWJlcihzX25kcywgMiwgJy4nLCAnICcpKTtcclxuXHQkKCcuanMtbmRzJykuZW1wdHkoKS5hcHBlbmQoJC5udW1iZXIobmQsIDIsICcuJywgJyAnKSk7XHRcclxuXHQkKCcudGVuZGVyLW9mZmVycy1pdG9nJykuc2xpZGVEb3duKFwic2xvd1wiKTtcclxuXHRcdFx0XHJcblx0XHR9IGVsc2VcclxuXHRcdFx0e1xyXG5cdFx0XHRcdC8vJCgnLmpzLW5vLW5kcywgLmpzLXMtbmRzLCAuanMtbmRzJykuZW1wdHkoJzAnKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHQkKCcudGVuZGVyLW9mZmVycy1pdG9nJykuc2xpZGVVcChcInNsb3dcIixmdW5jdGlvbigpIHsgJCh0aGlzKS5maW5kKCcuanMtbm8tbmRzLCAuanMtcy1uZHMsIC5qcy1uZHMnKS5lbXB0eSgpLmFwcGVuZCgnMCcpOyAgfSk7XHJcblx0XHRcdH1cclxufVxyXG5cclxuXHJcbi8v0L3QsNC20LDRgtGMIGVudGVyINC/0YDQuCDQstGF0L7QtNC1XHJcbi8vICB8XHJcbi8vIFxcL1xyXG5mdW5jdGlvbiBFbnRlckxvZ2luKGUpXHJcbntcclxuXHRpZihlLndoaWNoID09IDEzKSB7XHJcbiAgICAgICBMb2dpblllcygpO1xyXG4gICAgfVxyXG59XHJcblxyXG4vL9C90LDQv9C+0LzQvdC40YLRjCDQv9Cw0YDQvtC70Ywg0LIg0YTQvtGA0LzQtSDQvdCw0LnRgtC4XHJcbi8vICB8XHJcbi8vIFxcL1xyXG5mdW5jdGlvbiBSZWNvdmVyTG9naW4oKVxyXG57XHJcblx0dmFyIGVyciA9IDA7XHJcblx0JCgnLmpzLWZvcm0tb3BlbiAuZ2xvYWIxJykuZWFjaChmdW5jdGlvbihpLGVsZW0pIHtcclxuXHRpZigkKHRoaXMpLnZhbCgpID09ICcnKSAgeyQodGhpcykucGFyZW50cygnLmlucHV0XzIwMTgnKS5maW5kKCcuZXJyb3ItbWVzc2FnZScpLmVtcHR5KCkuYXBwZW5kKCfQv9C+0LvQtSDQvdC1INC30LDQv9C+0LvQvdC10L3QvicpO1x0ICQodGhpcykucGFyZW50cygnLmlucHV0XzIwMTgnKS5hZGRDbGFzcygncmVxdWlyZWRfaW5fMjAxOCcpOyBlcnIrKzsgfSBlbHNlIHskKHRoaXMpLnBhcmVudHMoJy5pbnB1dF8yMDE4JykucmVtb3ZlQ2xhc3MoJ3JlcXVpcmVkX2luXzIwMTgnKTt9XHRcdFxyXG59KTtcclxuXHRcdFxyXG5cdFxyXG5cclxuXHRcclxuXHRcclxuXHRpZihlcnI9PTApXHJcblx0XHR7XHJcblx0XHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLXJlY292ZXItcGFzc3dvcmQnKS5oaWRlKCk7XHJcblx0XHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLmhpZGUoKS5hZnRlcignPGRpdiBjbGFzcz1cImJfbG9hZGluZ19zbWFsbFwiIHN0eWxlPVwicG9zaXRpb246cmVsYXRpdmU7IHdpZHRoOiA0MHB4O3BhZGRpbmctdG9wOiA3cHg7dG9wOiBhdXRvO3JpZ2h0OiBhdXRvO2xlZnQ6IGNhbGMoNTAlIC0gMjBweCk7XCI+PGRpdiBjbGFzcz1cImJfbG9hZGluZ19jaXJjbGVfd3JhcHBlcl9zbWFsbFwiPjxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfY2lyY2xlX29uZV9zbWFsbFwiPjwvZGl2PjxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfY2lyY2xlX29uZV9zbWFsbCBiX2xvYWRpbmdfY2lyY2xlX2RlbGF5ZWRfc21hbGxcIj48L2Rpdj48L2Rpdj48L2Rpdj4nKTtcclxuXHRcdFx0XHJcblx0XHRcdFxyXG5cdFx0XHRcclxuXHRcdEFqYXhDbGllbnQoJ29wZW4nLCdyZWNvdmVyJywnUE9TVCcsMCwnQWZ0ZXJSZWNvdmVyTG9naW4nLDAsJ2xvZ2luLWZvcm0taycpO1x0XHJcblx0XHRcdFxyXG5cdFx0fSBlbHNlXHJcblx0XHRcdHtcclxuXHRcdFx0XHQkKCcuanMtZm9ybS1vcGVuIC5tZXNzYWdlLWZvcm0nKS5oaWRlKCk7XHJcblx0XHRcdH1cclxufVxyXG5mdW5jdGlvbiBBZnRlclJlY292ZXJMb2dpbihkYXRhLHVwZGF0ZSlcclxue1xyXG5cdCQoJy5qcy1mb3JtLW9wZW4gLm1lc3NhZ2UtZm9ybScpLmVtcHR5KCk7XHJcblx0aWYgKCBkYXRhLnN0YXR1cz09J3JlbG9hZCcgKVxyXG4gICAge1xyXG5cdFx0YXV0b1JlbG9hZCgpO1xyXG5cdH1cclxuXHRcclxuXHRcclxuXHRpZiggZGF0YS5zdGF0dXM9PSdvaycgKVxyXG5cdFx0e1xyXG5cdFx0XHR2YXIgbWFpbF9uYW1lPSQoJy5qcy1mb3JtLW9wZW4gLmpzLWluMScpLnZhbCgpO1xyXG5cdFx0XHQkKCcuanMtZm9ybS1vcGVuJykuZW1wdHkoKS5hcHBlbmQoJzxzcGFuIGNsYXNzPVwiaGVscC1tZXNzYWdlXCI+0J/RgNC+0LLQtdGA0YzRgtC1INGB0LLQvtGOINGN0LvQtdC60YLRgNC+0L3QvdGD0Y4g0L/QvtGH0YLRgy4g0JzRiyDQvtGC0L/RgNCw0LLQuNC70Lgg0L/QuNGB0YzQvNC+INC90LAg0Y3Qu9C10LrRgtGA0L7QvdC90YvQuSDQsNC00YDQtdGBIDxzdHJvbmc+JyttYWlsX25hbWUrJy48L3N0cm9uZz4g0J/QtdGA0LXQudC00LjRgtC1INC/0L4g0YHRgdGL0LvQutC1INCyINC/0LjRgdGM0LzQtSDQtNC70Y8g0YHQsdGA0L7RgdCwINC/0LDRgNC+0LvRjy48YnI+PGJyPtCV0YHQu9C4INC/0LjRgdGM0LzQsCDQvdC10YIg0LLQviDQstGF0L7QtNGP0YnQuNGFLCDRgtC+INC/0L7Qv9GA0L7QsdGD0LnRgtC1INC90LDQudGC0Lgg0LXQs9C+INCyINC00YDRg9Cz0LjRhSDQv9Cw0L/QutCw0YUgKNC90LDQv9GA0LjQvNC10YAsIMKr0KHQv9Cw0LzCuywgwqvQodC+0YbQuNCw0LvRjNC90YvQtSDRgdC10YLQuMK7INC40LvQuCDQtNGA0YPQs9C40LUpLjwvc3Bhbj48ZGl2IGNsYXNzPVwieWVzXCI+cTwvZGl2PicpOyBcclxuXHRcdH1cclxuXHRcclxuXHRpZiAoIGRhdGEuc3RhdHVzPT0nbG9naW5fZXJyb3InIClcclxuICAgIHtcclxuXHRcdHZhciBob29wPSQoJy5qcy1mb3JtLW9wZW4gLmpzLWluMScpLnBhcmVudHMoJy5pbnB1dF8yMDE4Jyk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5qcy1sb2cnKS5zaG93KCk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5iX2xvYWRpbmdfc21hbGwnKS5yZW1vdmUoKTtcclxuXHRcdGhvb3AuYWRkQ2xhc3MoJ3JlcXVpcmVkX2luXzIwMTgnKTtcclxuXHRcdGhvb3AuZmluZCgnLmVycm9yLW1lc3NhZ2UnKS5lbXB0eSgpLmFwcGVuZCgn0L/QvtC70LUg0LfQsNC/0L7Qu9C90LXQvdC+INC90LXQstC10YDQvdC+Jyk7XHRcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLXJlY292ZXItcGFzc3dvcmQnKS5zaG93KCk7XHJcblx0fVxyXG5cdFxyXG5cdC8v0LvQuNGH0L3Ri9C5INC60LDQsdC40L3QtdGCINC30LDQsdC70L7QutC40YDQvtCy0LDQvVxyXG5cdGlmICggZGF0YS5zdGF0dXM9PSdlbmFibGVkJyApXHJcbiAgICB7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5tZXNzYWdlLWZvcm0nKS5lbXB0eSgpLmFwcGVuZCgnwqvQntGI0LjQsdC60LAhINCS0LDRiCDQu9C40YfQvdGL0Lkg0LrQsNCx0LjQvdC10YIg0LfQsNCx0LvQvtC60LjRgNC+0LLQsNC9wrsnKS5zaG93KCk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5iX2xvYWRpbmdfc21hbGwnKS5yZW1vdmUoKTtcdFx0XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5qcy1sb2cnKS5zaG93KCk7XHRcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLXJlY292ZXItcGFzc3dvcmQnKS5zaG93KCk7XHJcblx0fVx0XHJcblx0XHJcblx0aWYgKCBkYXRhLnN0YXR1cz09J25vX2FjdGl2ZV9lbWFpbCcgKVxyXG4gICAge1xyXG5cdFx0JCgnLmpzLWZvcm0tb3BlbiAubWVzc2FnZS1mb3JtJykuZW1wdHkoKS5hcHBlbmQoJzxkaXY+wqvQntGI0LjQsdC60LAhINCS0LDRiNCwINGN0LvQtdC60YLRgNC+0L3QvdCw0Y8g0L/QvtGH0YLQsCDQvdC1INC/0L7QtNGC0LLQtdGA0LbQtNC10L3QsMK7PGJyPtCd0LXQstC+0LfQvNC+0LbQvdC+INC90LDQv9C+0LzQvdC40YLRjCDQv9Cw0YDQvtC70Yw8L2Rpdj4nKS5zaG93KCk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5iX2xvYWRpbmdfc21hbGwnKS5yZW1vdmUoKTtcdFx0XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5qcy1sb2cnKS5zaG93KCk7XHRcdFxyXG5cdH1cdFxyXG5cdFxyXG59XHJcblxyXG5cclxuXHJcbi8v0LvQvtCz0LjQvSDQv9Cw0YDQvtC70Ywv0L3QsNC20LDRgtC40LUg0LrQvdC+0L/QutC4INCy0L7QudGC0LhcclxuLy8gIHxcclxuLy8gXFwvXHJcbmZ1bmN0aW9uIExvZ2luWWVzKClcclxue1xyXG5cdFxyXG5cdGlmKCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLmlzKCcuY2xvY2snKSlcclxuXHRcdHtcclxuXHRcdFx0XHJcblx0XHR9IGVsc2VcclxuXHRcdFx0e1xyXG5cdFxyXG5cdHZhciBlcnIgPSAwO1xyXG5cclxuXHQkKCcuanMtZm9ybS1vcGVuIC5nbG9hYicpLmVhY2goZnVuY3Rpb24oaSxlbGVtKSB7XHJcblx0aWYoJCh0aGlzKS52YWwoKSA9PSAnJykgIHskKHRoaXMpLnBhcmVudHMoJy5pbnB1dF8yMDE4JykuZmluZCgnLmVycm9yLW1lc3NhZ2UnKS5lbXB0eSgpLmFwcGVuZCgn0L/QvtC70LUg0L3QtSDQt9Cw0L/QvtC70L3QtdC90L4nKTtcdCAkKHRoaXMpLnBhcmVudHMoJy5pbnB1dF8yMDE4JykuYWRkQ2xhc3MoJ3JlcXVpcmVkX2luXzIwMTgnKTsgZXJyKys7IH0gZWxzZSB7JCh0aGlzKS5wYXJlbnRzKCcuaW5wdXRfMjAxOCcpLnJlbW92ZUNsYXNzKCdyZXF1aXJlZF9pbl8yMDE4Jyk7fVx0XHRcclxufSk7XHJcblx0XHRcclxuXHRcclxuXHJcblx0XHJcblx0XHJcblx0aWYoZXJyPT0wKVxyXG5cdFx0e1xyXG5cdFx0XHQkKCcuanMtZm9ybS1vcGVuIC5qcy1sb2cnKS5oaWRlKCkuYWZ0ZXIoJzxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfc21hbGxcIiBzdHlsZT1cInBvc2l0aW9uOnJlbGF0aXZlOyB3aWR0aDogNDBweDtwYWRkaW5nLXRvcDogN3B4O3RvcDogYXV0bztyaWdodDogYXV0bztsZWZ0OiBjYWxjKDUwJSAtIDIwcHgpO1wiPjxkaXYgY2xhc3M9XCJiX2xvYWRpbmdfY2lyY2xlX3dyYXBwZXJfc21hbGxcIj48ZGl2IGNsYXNzPVwiYl9sb2FkaW5nX2NpcmNsZV9vbmVfc21hbGxcIj48L2Rpdj48ZGl2IGNsYXNzPVwiYl9sb2FkaW5nX2NpcmNsZV9vbmVfc21hbGwgYl9sb2FkaW5nX2NpcmNsZV9kZWxheWVkX3NtYWxsXCI+PC9kaXY+PC9kaXY+PC9kaXY+Jyk7XHJcblx0XHRcdFxyXG5cdFx0XHQkKCcuanMtZm9ybS1vcGVuIC5tZXNzYWdlLWZvcm0nKS5oaWRlKCk7XHJcblx0XHRcdFxyXG5cdFx0QWpheENsaWVudCgnb3BlbicsJ29wZW4nLCdQT1NUJywwLCdBZnRlckxvZ2luWWVzJywwLCdsb2dpbi1mb3JtLWsnKTtcdFxyXG5cdFx0XHRcclxuXHRcdH0gZWxzZVxyXG5cdFx0XHR7ICAgXHJcblx0XHRcdFx0RXJyb3JCdXQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycsJ9Ce0YjQuNCx0LrQsCDQt9Cw0L/QvtC70L3QtdC90LjRjyEnKTtcclxuXHRcdFx0XHRcclxuXHRcdFx0XHRcclxuXHRcdFx0fVxyXG5cdFx0XHRcdFxyXG5cdFx0XHR9XHJcbn1cclxuXHJcblxyXG5mdW5jdGlvbiBBZnRlckxvZ2luWWVzKGRhdGEsdXBkYXRlKVxyXG57XHJcblx0aWYgKCggZGF0YS5zdGF0dXM9PSdyZWxvYWQnICl8fCggZGF0YS5zdGF0dXM9PSdvaycgKSlcclxuICAgIHtcclxuXHRcdGF1dG9SZWxvYWQoKTtcclxuXHR9XHJcblx0XHJcblx0Ly/Qu9C40YfQvdGL0Lkg0LrQsNCx0LjQvdC10YIg0LfQsNCx0LvQvtC60LjRgNC+0LLQsNC9XHJcblx0aWYgKCBkYXRhLnN0YXR1cz09J2VuYWJsZWQnIClcclxuICAgIHtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLm1lc3NhZ2UtZm9ybScpLmVtcHR5KCkuYXBwZW5kKCfCq9Ce0YjQuNCx0LrQsCEg0JLQsNGIINC70LjRh9C90YvQuSDQutCw0LHQuNC90LXRgiDQt9Cw0LHQu9C+0LrQuNGA0L7QstCw0L3CuycpLnNob3coKTtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmJfbG9hZGluZ19zbWFsbCcpLnJlbW92ZSgpO1x0XHRcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLnNob3coKTtcdFx0XHJcblx0fVx0XHJcblxyXG5cdGlmICggZGF0YS5zdGF0dXM9PSdub19hY3RpdmVfZW1haWwnIClcclxuICAgIHtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLm1lc3NhZ2UtZm9ybScpLmVtcHR5KCkuYXBwZW5kKCc8ZGl2PsKr0J7RiNC40LHQutCwISDQktCw0YjQsCDRjdC70LXQutGC0YDQvtC90L3QsNGPINC/0L7Rh9GC0LAg0L3QtSDQv9C+0LTRgtCy0LXRgNC20LTQtdC90LDCuzwvZGl2PjxkaXYgY2xhc3M9XCJhY3RpdmF0ZV9tYWlsX2xpbmsganMtYWN0aXZlLWxpbmtcIj48c3Bhbj7QvtGC0L/RgNCw0LLQuNGC0Ywg0L/QuNGB0YzQvNC+INC00LvRjyDQsNC60YLQuNCy0LDRhtC40Lg8L3NwYW4+PC9kaXY+Jykuc2hvdygpO1xyXG5cdFx0JCgnLmpzLWZvcm0tb3BlbiAuYl9sb2FkaW5nX3NtYWxsJykucmVtb3ZlKCk7XHRcdFxyXG5cdFx0JCgnLmpzLWZvcm0tb3BlbiAuanMtbG9nJykuc2hvdygpO1x0XHRcclxuXHR9XHRcclxuXHRcclxuXHRcclxuXHQvL9C/0YDQtdCy0YvRiNC10L3QviDQutC+0LvQuNGH0LXRgdGC0LLQviDQv9C+0L/Ri9GC0L7QulxyXG5cdGlmICggZGF0YS5zdGF0dXM9PSd0aW1lX2xpbWl0JyApXHJcbiAgICB7XHJcblx0XHRcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLm1lc3NhZ2UtZm9ybScpLmVtcHR5KCkuYXBwZW5kKCfCq9Ch0LvQuNGI0LrQvtC8INC80L3QvtCz0L4g0L3QtdGD0YHQv9C10YjQvdGL0YUg0L/QvtC/0YvRgtC+0Log0LDQstGC0L7RgNC40LfQsNGG0LjQuC4g0J3QtdC+0LHRhdC+0LTQuNC80L4g0L/QvtC00L7QttC00LDRgtGMICcrZGF0YS5lY2hvKyfCuycpLnNob3coKTtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmJfbG9hZGluZ19zbWFsbCcpLnJlbW92ZSgpO1x0XHRcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLmFkZENsYXNzKCdjbG9jaycpLnNob3coKTtcclxuXHRcdGluaXRpYWxpemVUaW1lckxvZ2luKGRhdGEuZWNobzEpO1xyXG5cdH1cclxuXHRcclxuXHRcclxuXHRcclxuXHQvL9C+0YjQuNCx0LrQsCDQu9C+0LPQuNC9XHJcblx0aWYgKCBkYXRhLnN0YXR1cz09J2xvZ2luX2Vycm9yJyApXHJcblx0e1xyXG5cdFx0dmFyIGhvb3A9JCgnLmpzLWZvcm0tb3BlbiAuanMtaW4xJykucGFyZW50cygnLmlucHV0XzIwMTgnKTtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLnNob3coKTtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmJfbG9hZGluZ19zbWFsbCcpLnJlbW92ZSgpO1xyXG5cdFx0aG9vcC5hZGRDbGFzcygncmVxdWlyZWRfaW5fMjAxOCcpO1xyXG5cdFx0aG9vcC5maW5kKCcuZXJyb3ItbWVzc2FnZScpLmVtcHR5KCkuYXBwZW5kKCfQv9C+0LvQtSDQt9Cw0L/QvtC70L3QtdC90L4g0L3QtdCy0LXRgNC90L4nKTtcclxuXHR9XHJcblx0Ly/QvtGI0LjQsdC60LAg0L/QsNGA0L7Qu9GMXHRcclxuXHRpZiAoIGRhdGEuc3RhdHVzPT0ncGFzc3dvcmRfZXJyb3InIClcclxuICAgIHtcclxuXHRcdHZhciBob29wPSQoJy5qcy1mb3JtLW9wZW4gLmpzLWluMicpLnBhcmVudHMoJy5pbnB1dF8yMDE4Jyk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5qcy1sb2cnKS5zaG93KCk7XHJcblx0XHQkKCcuanMtZm9ybS1vcGVuIC5iX2xvYWRpbmdfc21hbGwnKS5yZW1vdmUoKTtcclxuXHRcdGhvb3AuYWRkQ2xhc3MoJ3JlcXVpcmVkX2luXzIwMTgnKTtcclxuXHRcdGhvb3AuZmluZCgnLmVycm9yLW1lc3NhZ2UnKS5lbXB0eSgpLmFwcGVuZCgn0L/QvtC70LUg0LfQsNC/0L7Qu9C90LXQvdC+INC90LXQstC10YDQvdC+Jyk7XHRcdFxyXG5cdH1cclxuXHQvL9C+0YjQuNCx0LrQsCDQu9C+0LPQuNC9INC4INC/0LDRgNC+0LvRjFxyXG5cdGlmICggZGF0YS5zdGF0dXM9PSdwYXNzd29yZF9sb2dpbicgKVxyXG4gICAge1xyXG5cdFx0dmFyIGhvb3A9JCgnLmpzLWZvcm0tb3BlbiAuZ2xvYWInKS5wYXJlbnRzKCcuaW5wdXRfMjAxOCcpO1xyXG5cdFx0XHRcdCQoJy5qcy1mb3JtLW9wZW4gLmpzLWxvZycpLnNob3coKTtcclxuXHRcdCQoJy5qcy1mb3JtLW9wZW4gLmJfbG9hZGluZ19zbWFsbCcpLnJlbW92ZSgpO1xyXG5cdFx0aG9vcC5hZGRDbGFzcygncmVxdWlyZWRfaW5fMjAxOCcpO1xyXG5cdFx0aG9vcC5maW5kKCcuZXJyb3ItbWVzc2FnZScpLmVtcHR5KCkuYXBwZW5kKCfQvdC10LLQtdGA0L3Ri9C5IGUtbWFpbCDQuNC70Lgg0L/QsNGA0L7Qu9GMJyk7XHJcblx0XHRcclxuXHR9XHJcbn1cclxuXHJcbiJdfQ==
