//submit order
$('body').on('beforeSubmit', 'form#form-order', function () {
    var form = $(this);
    $('#submit-order').attr('value', 'Loading...')
    // return false if form still have some validation errors
    if (form.find('.has-error').length)
    {
        return false;
    }
    // submit form
    $.ajax({
        url: apis + 'ajax/order',
        type: 'post',
        data: form.serialize(),
        success: function (data)
        {
            document.getElementById("form-order").reset();
            $('.alert-checkout').show();
            $('.alert-checkout').html("<button type=button class=close data-dismiss=alert aria-label=Close><span aria-hidden=true>×</span></button>Cảm ơn bạn đã mua sản phẩm của chúng tôi!");
            $('#submit-order').attr('value', 'Đặt hàng')
        },
        error: function ()
        {
            console.log('internal server error');
        }
    });
    return false;
});

var chat_realtime = function (j, k, l, m, n, imageDir, status, countMsgRef, userInfo) {

    var tampungImg = [];
//    getUser();
    j.on("child_added", function (a) {
        var data = a.val();
        console.log(data);
        if ($('#' + data.actor + '_' + data.product_id).length) {
            $('#' + data.actor + '_' + data.product_id + ' .time').html(timing(new Date(data.login)))
        } else {
            var b = '<li id="product_' + data.actor + '_' + data.product_id + '" class="user bounceInDown" data-actor ="' + data.actor + '"  data-pid ="' + data.product_id + '">';
            b += '	<a href="#" class="clearfix">';
            b += '		<img src="' + userInfo.link_cdn + '/image.php?src=' + data.avatar + '&size=45x45">';
            b += '		<div class="users-name">';
            b += '		 <strong>' + data.product_name + '</strong>';
            b += '		</div>';
            b += '		<div class="last-message msg">' + data.last_msg + '</div>';
            b += '		<small class="time text-muted">' + timing(new Date(data.last_msg_time)) + '</small>';
            if (data.last_msg_count > 0) {
                b += '<small class="chat-alert label label-primary" style="display:block">' + data.last_msg_count + '</small>';
            } else {
                b += '<small class="chat-alert label label-primary">0</small>';
            }
            b += '		<small class="user">' + data.fullname + '</small>';
            b += '	</a>';
            b += '</li>';
            $('.users-list').prepend(b);
        }
        j.child(a.key).remove();
    });
    k.on("child_added", function (a) {
        var owner = a.val().owner, actor = a.val().actor, product_id = a.val().product_id;
        // inbox 
        if (actor == userInfo.owner) {
            document.querySelector('#product_' + owner + '_' + product_id + ' .time').innerHTML = timing(new Date(a.val().date));
            document.querySelector('#product_' + owner + '_' + product_id + ' .last-message').innerHTML = '<i class="fa fa-reply"></i> ' + htmlEntities(a.val().message);
            if ($('#product_' + owner + '_' + product_id).hasClass('active')) {
                document.querySelector('.chat').innerHTML += (chatFirebase(a.val()))
            } else {
                $('#product_' + owner + '_' + product_id + ' .chat-alert').show();
                var count = parseInt(document.querySelector('#product_' + owner + '_' + product_id + ' .chat-alert').innerHTML) + 1;
                countMsg(owner, actor, product_id, 'add');
                document.querySelector('#product_' + owner + '_' + product_id + ' .chat-alert').innerHTML = (count);
            }
        }

        // send message
        else if (owner == userInfo.owner) {
            console.log('#product_' + actor + '_' + product_id + ' .time');
            document.querySelector('#product_' + actor + '_' + product_id + ' .time').innerHTML = timing(new Date(a.val().date));
            document.querySelector('#product_' + actor + '_' + product_id + ' .last-message').innerHTML = '<i class="fa fa-check"></i> ' + htmlEntities(a.val().message);
            document.querySelector('.chat').innerHTML += (chatFirebase(a.val()))
        }
        var c = $('.chat');
        var d = c[0].scrollHeight;
        c.scrollTop(d);
        k.child(a.key).remove()
    });
    function countMsg(owner, actor, product_id, action) {
        $.ajax({
            url: l + 'ajax/countmsg',
            type: "post",
            data: {owner: owner, actor: actor, product_id: product_id, action: action},
            crossDomain: true,
            dataType: 'json',
            success: function (a) {
                var arr = {
                    type: a.type,
                    user_id: a.user_id,
                    count: a.last_msg_count,
                    action: action
                }
                if (a.type == 'seller') {
                    countMsgRef.child('countmsg_seller_' + a.user_id).remove();
                    countMsgRef.child('countmsg_seller_' + a.user_id).push(arr);
                } else {
                    countMsgRef.child('countmsg_customer_' + a.user_id).remove();
                    countMsgRef.child('countmsg_customer_' + a.user_id).push(arr);
                }
            }
        })
    }
    //send chat
    document.querySelector('#send').addEventListener("click", function (h) {
        var a = new Date(),
                b = a.getDate(),
                c = (a.getMonth() + 1),
                d = a.getFullYear(),
                e = a.getHours(),
                f = a.getMinutes(),
                g = a.getSeconds(),
                date = d + '-' + (c < 10 ? '0' + c : c) + '-' + (b < 10 ? '0' + b : b) + ' ' + (e < 10 ? '0' + e : e) + ':' + (f < 10 ? '0' + f : f) + ':' + (g < 10 ? '0' + g : g);
        h.preventDefault();
        var il = tampungImg.length;
        if (document.querySelector('#message').value != '') {

            // insert mysql
            $.ajax({
                url: l + 'ajax/sendmessage',
                type: "post",
                data: {
                    product_id: $('#conversation_product_id').val(),
                    actor: $('#conversation_actor').val(),
                    message: document.querySelector('#message').value,
                    images: JSON.stringify(tampungImg),
                    date: date
                },
                crossDomain: true,
                success: function (a) {
                    if (il > 0) {
                        for (hit = 0; hit < il; hit++) {
                            if (hit == 0) {
                                var i = {
                                    fullname: a.fullname,
                                    owner: a.owner,
                                    actor: a.actor,
                                    avatar: a.avatar,
                                    message: a.message,
                                    images: tampungImg[hit].name,
                                    product_id: a.product_id,
                                    date: date
                                };
                            } else {
                                var i = {
                                    fullname: a.fullname,
                                    owner: a.owner,
                                    actor: a.actor,
                                    avatar: a.avatar,
                                    message: '',
                                    images: tampungImg[hit].name,
                                    product_id: a.product_id,
                                    date: date
                                };
                            }
                            k.push(i);
                        }
                    } else {
                        var i = {
                            fullname: a.fullname,
                            owner: a.owner,
                            actor: a.actor,
                            avatar: a.avatar,
                            message: a.message,
                            images: '',
                            product_id: a.product_id,
                            date: date
                        };

                        // push firebase
                        k.push(i);
                    }
                    tampungImg = [];
                    document.querySelector('#message').value = '';
                    document.getElementById('reviewImg').innerHTML = '';
                }
            });

        } else {
            $(".help-block-error").html('Bạn chưa nhập nội dung!');
        }
    }, false);

    $('body').on('click', '.user', function () {
        $('.chat').html('');
        $('.user').removeClass("active");
        $('#chat-msg').show();
        $('.product-info').show();
        $('.checkout').show();
        $('.chat-users').css('height', '63%');
        $(this).addClass("active");
        var product_id = $(this).data('pid'), actor = $(this).data('actor');
        $('#product_' + actor + '_' + product_id + ' .chat-alert').hide();
        $('#conversation_actor').val(actor);
        $('#conversation_product_id').val(product_id);
        countMsg(actor, userInfo.owner, product_id, 'delete');
        messages(actor, product_id);

        return false
    });

    function getUser() {
        $.ajax({
            url: l + 'ajax/user',
            type: "get",
            crossDomain: true,
            dataType: 'json',
            success: function (data) {
                var a = data.data;
                var b = '';
                $.each(a, function (i, a) {
                    b += '<li id="product_' + a.owner.id + '_' + a.product.id + '" class="user bounceInDown" data-actor ="' + a.owner.id + '"  data-pid ="' + a.product.id + '">';
                    b += '	<a href="#" class="clearfix">';
                    b += '		<img src="' + userInfo.link_cdn + '/image.php?src=' + a.avatar + '&size=45x45">';
                    b += '		<div class="users-name">';
                    b += '		 <strong>' + a.product.title + '</strong>';
                    b += '		</div>';
                    b += '		<div class="last-message msg">' + a.last_msg + '</div>';
                    b += '		<small class="time text-muted">' + timing(new Date(a.last_msg_time)) + '</small>';
                    if (a.last_msg_count > 0) {
                        b += '<small class="chat-alert label label-primary" style="display:block">' + a.last_msg_count + '</small>';
                    } else {
                        b += '<small class="chat-alert label label-primary">0</small>';
                    }
                    b += '<small class="user">' + a.owner.fullname + '</small>';
                    b += '	</a>';
                    b += '</li>';
                });

                $('.users-list').html(b);
                $('.chat').html('');
                $('.product-info').show();
                $('.checkout').show();
                $('#chat-msg').show();
                $('.chat-users').css('height', '63%');
                $('#conversation_actor').val(a[0].owner.id);
                $('#conversation_product_id').val(a[0].product.id);
                $('#product_' + a[0].owner.id + '_' + a[0].product.id).addClass("active");
                messages(a[0].owner.id, a[0].product.id);

            }
        })
    }

    function chatFirebase(a) {
        var b = '';
        var img = '';
        console.log(a);
        if (a.images != '') {
            img = '<img class="imageDir" src="/uploads/' + a.images + '"/>';
        }
        if (a.owner == userInfo.owner) {
            b = '<li class="right clearfix">' + '<span class="chat-img pull-right">' + '<img src="' + userInfo.link_cdn + '/image.php?src=' + a.avatar + '&size=45x45">' + '</span>' + '<div class="chat-body clearfix">' + '<p class="msg">' + img + urltag(htmlEntities(a.message)) + '</p>' + '<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' + timing(new Date(a.date)) + '</small>' + '</div>' + '</li>'
        } else {
            b = '<li class="left clearfix">' + '<span class="chat-img pull-left">' + '<img src="' + userInfo.link_cdn + '/image.php?src=' + a.avatar + '&size=45x45">' + '</span>' + '<div class="chat-body clearfix">' + '<div class="kepala">' + '<strong class="primary-font">' + a.fullname + '</strong>' + '<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' + timing(new Date(a.date)) + '</small>' + '</div>' + '<p class="msg">' + img + urltag(htmlEntities(a.message)) + '</p>' + '</div>' + '</li>'
        }
        return b
    }
    //get msg
    function messages(actor, product_id) {
        $.ajax({
            url: l + 'ajax/messages',
            type: "post",
            data: {
                product_id: product_id,
                actor: actor
            },
            crossDomain: true,
            dataType: 'json',
            success: function (data) {
                var a = data.conversation;
                var user = data.owner;
                var product = data.product;
                var b = '';
                $.each(a, function (i, a) {
                    var img = '';
                    if (typeof a.image != 'undefined') {
                        img = '<img class="imageDir" src="' + a.image + '"/>';
                    }
                    if (a.owner == userInfo.owner) {
                        b += '<li class="right">' + '<span class="chat-img pull-right">' + '<img src="' + userInfo.link_cdn + '/image.php?src=' + a.avatar + '&size=45x45">' + '</span>' + '<div class="chat-body clearfix">' + '<p class="msg">' + img + urltag(htmlEntities(a.message)) + '</p>' + '<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' + timing(new Date(a.date)) + '</small>' + '</div>' + '</li>'
                    } else {
                        b += '<li class="left clearfix">' + '<span class="chat-img pull-left">' + '<img src="' + userInfo.link_cdn + '/image.php?src=' + a.avatar + '&size=45x45">' + '</span>' + '<div class="chat-body clearfix">' + '<div class="kepala">' + '<strong class="primary-font">' + a.fullname + '</strong>' + '<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' + timing(new Date(a.date)) + '</small>' + '</div>' + '<p class="msg">' + img + urltag(htmlEntities(a.message)) + '</p>' + '</div>' + '</li>'
                    }
                    if (a.actor == userInfo.owner) {
                        document.querySelector('#product_' + a.owner + '_' + product._id + ' .last-message').innerHTML = '<i class="fa fa-reply"></i> ' + htmlEntities(a.message);
                    } else {
                        document.querySelector('#product_' + a.actor + '_' + product._id + ' .last-message').innerHTML = '<i class="fa fa-check"></i> ' + htmlEntities(a.message);
                    }
                });
                $('.chat').prepend(b);
                $('.chat-header').show();
                $('.contact-name').html(data.msg.fullname);
                $('.chat-header .name').html(product.title);
                $('.chat-header .avatar').attr('src', userInfo.link_cdn + '/image.php?src=' + product.images[0] + '&size=45x45');
                $('#product_id').val(product.id);
                //order
                $('#order-product_id').val(product.id);
                $('#order-product_province_id').val(product.id);
                $('#order-seller_id').val(data.seller.id);

                $('#product-info .product-des').html(getProduct(product));
                $('#product-info .seller').html(getSeller(data.seller));
                // delete 

                var c = $('.chat');
                var d = c[0].scrollHeight;
                c.scrollTop(d)
            }
        })
    }

    function getProduct(data) {
        var link = userInfo.link_frontend + '/' + data.slug + '-' + data._id;
        var html = '';
        html += '<div class="media"><div class="media-left"><a target="_blank" href="' + link + '"><img class="media-object img-thumbnail" src="' + userInfo.link_cdn + '/image.php?src=' + data.images[0] + '&size=150x150" width="100"></a></div><div class="media-body"><a target="_blank" href="' + link + '"><h4 class="media-heading">' + data.title + '</h4></a><p><a target="_blank" class="btn btn-success" href="' + link + '">Đặt hàng</a></p></div></div>';
        html += '<ul style="padding:0">';
        html += '<li></li>';
        html += '</ul>';
        return html;
    }

    function getSeller(data) {
        var category = [], certificate = [];
        for (var i = 0; i < data.category.length; i++) {
            category[i] = data.category[i].title;
        }
        for (var i = 0; i < data.certificate.length; i++) {
            certificate[i] = data.certificate[i].name;
        }
        var html = '<ul style="padding:0">';
        html += '<li><h4>Thông tin nhà vườn<h4></li>';
        html += '<li>Tên nhà vườn: <a target="_blank" href="' + data.link + '">' + data.garden_name + '</a></li>';
        html += '<li>Sản phẩm cung cấp: ' + category.join() + '</li>';
        html += '<li>Thương hiệu: ' + data.trademark + '</li>';
        html += '<li>Chứng nhận: ' + certificate + '</li>';
        html += '<li>Quy mô nhà vườn: ' + data.acreage + '</li>';
        html += '<li>Địa chỉ: ' + data.address + '</li>';
        html += '<li>Phí bảo hiểm: ' + data.insurance_money + '</li>';
        html += '</ul>';
        return html;
    }

    function htmlEntities(a) {
        return String(a).replace(/</g, '&lt;').replace(/>/g, '&gt;')
    }

    function timing(a) {
        var s = Math.floor((new Date() - a) / 1000),
                i = Math.floor(s / 31536000);
        if (i > 1) {
            return i + " năm trước"
        }
        i = Math.floor(s / 2592000);
        if (i > 1) {
            return i + " tháng trước"
        }
        i = Math.floor(s / 86400);
        if (i > 1) {
            return i + " ngày trước"
        }
        i = Math.floor(s / 3600);
        if (i > 1) {
            return i + " giờ trước"
        }
        i = Math.floor(s / 60);
        if (i > 1) {
            return i + " phút trước"
        }
        return (Math.floor(s) > 0 ? Math.floor(s) + " giây ago" : "vừa mới đây")
    }

    function urltag(d, e) {
        var f = {
            yutub: {
                regex: /(^|)(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*)(\s+|$)/ig,
                template: "<iframe class='yutub' src='//www.youtube.com/embed/$3' frameborder='0' allowfullscreen></iframe>"
            },
            link: {
                regex: /((^|)(https|http|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,
                template: "<a href='$1' target='_BLANK'>$1</a>"
            },
            email: {
                regex: /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi,
                template: '<a href=\"mailto:$1\">$1</a>'
            }
        };
        var g = $.extend(f, e);
        $.each(g, function (a, b) {
            d = d.replace(b.regex, b.template)
        });
        return d
    }

    // upload images
    function convertDataURIToBinary(dataURI) {
        var BASE64_MARKER = ';base64,';
        var base64Index = dataURI.indexOf(BASE64_MARKER) + BASE64_MARKER.length;
        var base64 = dataURI.substring(base64Index);
        var raw = window.atob(base64);
        var rawLength = raw.length;
        var array = new Uint8Array(new ArrayBuffer(rawLength));

        for (i = 0; i < rawLength; i++) {
            array[i] = raw.charCodeAt(i);
        }
        return array;
    }

    function readMultipleImg(evt) {
        //Retrieve all the files from the FileList object
        var files = evt.target.files;

        if (files) {
            for (var i = 0, f; f = files[i]; i++) {
                if (/(jpe?g|png|gif)$/i.test(f.type)) {
                    var r = new FileReader();
                    r.onload = (function (f) {
                        return function (e) {
                            var base64Img = e.target.result;
                            var binaryImg = convertDataURIToBinary(base64Img);
                            var blob = new Blob([binaryImg], {type: f.type});
                            var x = tampungImg.length;
                            var blobURL = window.URL.createObjectURL(blob);
                            var fileName = makeid(f.name.split('.').pop());
                            tampungImg[x] = {name: fileName, type: f.type, size: f.size, binary: Array.from(binaryImg)};
                            document.getElementById('reviewImg').innerHTML += '<img src="' + blobURL + '" data-idx="' + fileName + '" class="tmpImg" title="Hapus gambar"/>';
                        };
                    })(f);

                    r.readAsDataURL(f);
                } else {
                    alert("Failed file type");
                }
            }
        } else {
            alert("Failed to load files");
        }
    }

    function makeid(x) {
        var d = new Date();
        var text = d.getTime();
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text + '.' + x;
    }

    $('body').on('click', '.tmpImg', function () {
        var k = $(this).data('idx');
        tampungImg = tampungImg.filter(function (obj) {
            return obj.name !== k;
        });
        $(this).remove();
        return false;
    });

    document.getElementById('fileinput').addEventListener('change', readMultipleImg, false);

}
