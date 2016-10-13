var host = 'https://checkout.pay.g2a.com';
"use strict";
function listenMessage(a) {
    switch (a.data.action) {
        case"reload":
            window.location.href = a.data.url;
            break;
        case"insert":
            document.head.innerHTML = document.head.innerHTML + a.data.link;
            break;
        case"styles":
            var b = a.data.container, c = a.data.attribute, d = a.data.value;
            document.getElementById(b).style[c] = d;
            break;
        case"transaction":
            if (void 0 !== a.data.transaction_id && null !== a.data.transaction_id) {
                var e = document.getElementById(objG2APay.getButtonId());
                e.outerHTML = "", e.remove(), document.getElementById(objG2APay.getCheckoutFormId()).innerHTML += '<span id="transactionID" data-i18n="Your transaction ID">' + i18next.t("Your transaction ID", {
                        transactionid: a.data.transaction_id,
                        interpolation: {prefix: "__", suffix: "__"}
                    }) + "</span>"
            }
    }
}
var G2APay = function () {
    var url = host + "/index/init/", iframe, words, items, params, checkoutForm, iframeId = "iframePayG2a", buttonId = "pay-g2a-button", checkoutFormId = "checkoutForm", http = new XMLHttpRequest, dataHolder = document.querySelector('script[data-id="pay-g2a-script"]'), api_hash = dataHolder.getAttribute("data-key"), email = dataHolder.getAttribute("data-email"), amount = dataHolder.getAttribute("data-amount"), currency = dataHolder.getAttribute("data-currency"), order_id = dataHolder.getAttribute("data-order-id"), process_payment = dataHolder.getAttribute("data-process-payment"), url_ok = dataHolder.getAttribute("data-url-ok"), url_failure = dataHolder.getAttribute("data-url-failure"), url_pending = dataHolder.getAttribute("data-url-pending"), url_callback = dataHolder.getAttribute("data-url-callback"), url_before_click = dataHolder.getAttribute("data-url-before-click"), url_alt_donation = dataHolder.getAttribute("data-url-alt-donation"), ext_engine = dataHolder.getAttribute("data-ext-engine"), ext_data = dataHolder.getAttribute("data-ext-data"), description = dataHolder.getAttribute("data-description"), username = dataHolder.getAttribute("data-username"), escrow_price = dataHolder.getAttribute("data-escrow-price"), token = dataHolder.getAttribute("data-token"), app_secret = dataHolder.getAttribute("data-app-secret"), app_fee_amount = dataHolder.getAttribute("data-app-fee-amount"), new_customer = dataHolder.getAttribute("data-new-customer"), promo_action = dataHolder.getAttribute("data-promo-action"), is_partner = dataHolder.getAttribute("data-is-partner"), fee_owner = dataHolder.getAttribute("data-fee-owner"), is_mobile = dataHolder.getAttribute("data-is-mobile"), platform = dataHolder.getAttribute("data-platform"), subscription = dataHolder.getAttribute("data-subscription"), subscription_product_name = dataHolder.getAttribute("data-subscription-product-name"), subscription_type = dataHolder.getAttribute("data-subscription-type"), subscription_period = dataHolder.getAttribute("data-subscription-period"), subscription_start_date = dataHolder.getAttribute("data-subscription-start-date"), custom = dataHolder.getAttribute("data-custom"), regexItems = /[^[\]]+(?=])/g, dataItems = [], getData = function () {
        for (var a = 0, b = dataHolder.attributes, c = b.length; c > a; a++)"src" !== b[a].name && "data-id" !== b[a].name && "data-items" === b[a].name.substr(0, 10) && (words = b[a].name.match(regexItems), dataItems.hasOwnProperty(words[0]) || (dataItems[words[0]] = {}), dataItems[words[0]].hasOwnProperty(words[1]) || (dataItems[words[0]][words[1]] = b[a].value));
        items = JSON.stringify(dataItems)
    }, prepareData = function () {
        var paramKeys = ["api_hash", "email", "amount", "currency", "order_id", "process_payment", "url_ok", "url_failure", "url_pending", "url_callback", "url_before_click", "url_alt_donation", "ext_engine", "ext_data", "description", "username", "escrow_price", "new_customer", "token", "app_secret", "app_fee_amount", "items", "is_partner", "promo_action", "fee_owner", "subscription", "subscription_product_name", "subscription_type", "subscription_period", "subscription_start_date", "is_mobile", "platform", "custom"], requestParams = [];
        for (var i in paramKeys)if (paramKeys.hasOwnProperty(i)) {
            var varValue = eval(paramKeys[i]);
            requestParams.push(paramKeys[i] + "=" + encodeURIComponent(null !== varValue ? varValue + "" : ""))
        }
        params = requestParams.join("&")
    }, sendData = function () {
        http.open("POST", url, !0), http.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), http.withCredentials = !0, http.onreadystatechange = function () {
            4 == http.readyState && 200 == http.status && renderIframe()
        }, http.send(params)
    }, renderIframe = function () {
        iframe = document.createElement("iframe"), iframe.id = iframeId, iframe.name = iframeId, iframe.style.display = "none", iframe.style.visibility = "hidden", iframe.style.zIndex = "9999", iframe.style.border = "0px none transparent", iframe.style.overflowX = "hidden", iframe.style.overflowY = "auto", iframe.style.visibility = "visible", iframe.style.margin = "0px", iframe.style.padding = "0px", iframe.style.padding = "0px", iframe.style.position = "fixed", iframe.style.left = "0px", iframe.style.top = "0px", iframe.style.width = "100%", iframe.style.height = "100%", iframe.style.backgroundColor = "rgba(0, 0, 0, 0.00392157)", iframe.onload = frameLoaded()
    }, frameLoaded = function () {
        document.body.appendChild(iframe), iframe.contentWindow.document.open(), http.responseText.length > 0 && (iframe.contentWindow.document.write(http.responseText), renderButton()), iframe.contentWindow.document.close()
    }, renderButton = function () {
        if (checkoutForm = document.getElementById(checkoutFormId), null === checkoutForm) {
            var a = document.createElement("div");
            a.setAttribute("id", checkoutFormId), "head" !== dataHolder.parentNode.nodeName.toLowerCase() ? dataHolder.parentNode.appendChild(a) : document.getElementsByTagName("body")[0].appendChild(a), a.appendChild(dataHolder), checkoutForm = a
        }
        checkoutForm.innerHTML += '<div id="' + buttonId + '" class="' + buttonId + '"><span></span></div>', bindClickEvent()
    }, bindClickEvent = function () {
        document.getElementById(buttonId).addEventListener("click", function () {
            run()
        }, !1)
    }, run = function () {
        if (document.getElementById(iframeId).contentWindow.document.getElementById("g2a-listener-loaded")) {
            document.body.style.overflow = "hidden", document.getElementById(iframeId).style.display = "block";
            var a = {};
            a.action = "open-modal", a.url_before_click = url_before_click;
            var b = document.getElementById(iframeId).contentWindow;
            return b.postMessage(a, "*"), !0
        }
        return !1
    };
    return {
        getButtonId: function () {
            return buttonId
        }, getCheckoutFormId: function () {
            return checkoutFormId
        }, process: function () {
            return run()
        }, init: function () {
            getData(), prepareData(), sendData()
        }
    }
}, objG2APay = new G2APay;
objG2APay.init(), window.addEventListener ? window.addEventListener("message", listenMessage, !1) : window.attachEvent("onmessage", listenMessage);
"use strict";
!function () {
    var a = !1, b = function () {
        var b = function () {
            var b = document.createElement("script");
            b.setAttribute("type", "text/javascript"), b.setAttribute("src", "https://url.g2a.com/trace"), document.getElementsByTagName("body")[0].appendChild(b), a = !0
        };
        return {
            init: function () {
                a || b()
            }
        }
    }, c = document.getElementsByTagName("body");
    "undefined" != typeof c && "undefined" != typeof c[0] ? (new b).init() : document.addEventListener("DOMContentLoaded", function () {
        (new b).init()
    }, !1)
}();