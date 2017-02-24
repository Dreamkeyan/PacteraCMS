$(document).ready(function () {

    var isEdit = $("input[name=id]").length > 0 ? true : false;
    var icon = "<i class='fa fa-exclamation-triangle'></i>";
    var allcates = $.parseJSON($("#cates").val());
    var alldata = $.parseJSON($("#data").val());

    function init() {
        if (isEdit) {
            fillForm();
        }
    }

    function fillForm() {
        if (parseInt(alldata.model_id)) {
            $("#Pro-model").val(alldata.model_id).trigger('change');
        }
        if (alldata.images) {
            $(".upload-result > img").each(function (i) {
                if (alldata.images[i]) {
                    $(this).attr("src", alldata.images[i]['img_url']);
                }
            });
            $("input[type=hidden][name='thumb_img[]']").each(function (i) {
                if (alldata.images[i]) {
                    $(this).val(alldata.images[i]['img_url']);
                }
            });
        }
        if (alldata.category_id) {
            var cate1 = $("select[name=cate1]");
            var cate2 = $("select[name=cate2]");
            var cate3 = $("select[name=cate3]");
            var pcate, tagcat = getCate(alldata.category_id);
            if (!parseInt(tagcat.pid)) {
                cate1.val(alldata.category_id).trigger('change');
            } else {
                pcate = getCate(tagcat.pid);
                if (!parseInt(pcate.pid)) {
                    cate1.val(pcate.id).trigger('change');
                    cate2.val(tagcat.id).trigger('change');
                } else {
                    topcat = getCate(pcate.pid);
                    cate1.val(topcat.id).trigger('change');
                    cate2.val(pcate.id).trigger('change');
                    cate3.val(tagcat.id);
                }
            }
        }
    }

    function getAttrVal(attrid) {
        var value = '';
        $.each(alldata.attrs, function (k, v) {
            if (v.attr_id == attrid) {
                value = v.attr_value;
            }
        });
        return value;
    }

    function fillAttrSpecsData() {
        if (alldata.attrs) {
            $("#attr-table").find("input, select, textarea").each(function () {
                var attrid = $(this).attr("attr-id");
                var value = getAttrVal(attrid);
                $(this).val(value);
            });
        }
        if (alldata.specs) {
            var itemids = [];
            $.each(alldata.specs, function (i, n) {
                var ids = n.key.split("_");
                itemids = $.unique($.merge(itemids, ids));
            });
            $("#spec-table").find("button").each(function () {
                var val = $(this).attr("spec-id");
                if ($.inArray(val, itemids) !== -1) {
                    $(this).addClass('active');
                }
            });
            getSpecsTable(itemids);
        }
    }

    function getCate(catid) {
        var item = '';
        $.each(allcates, function (k, v) {
            if (v.id == catid) {
                item = v;
            }
        });
        return item;
    }

    $("#goods-form").validate({
        messages: {
            shop_id: icon + '请选择一个店铺！',
            name: icon + '商品名称不能为空！',
            cate1: icon + '请选择一个商品分类！',
            brand_id: icon + '请选择一个品牌！',
            sale_price: icon + '本店售价不能为空！',
            market_price: icon + '市场价不能为空！',
            stock_price: icon + '进货价不能为空！',
            weight: icon + '商品重量不能为空！',
            store_count: icon + '库存数量不能为空！',
        }
    });

    function fillSpecs(specs) {
        var html = '';
        $.each(specs, function (k, v) {
            var options = '';
            if (v.items) {
                $.each(v.items, function (sk, sv) {
                    options += '<button class="btn btn-default" spec-id="' + sv.id + '" type="button">' + sv.item + '</button>';
                });
            }
            html += '<tr><td>' + v.spec_name + '</td><td>' + options + '</td></tr>';
        });
        $("#spec-table").html(html);
    }

    function fillAttrs(attrs) {
        var html = '';
        $.each(attrs, function (k, v) {
            switch (parseInt(v.attr_type)) {
                case 1:
                    html += '<tr><td>' + v.attr_name + '</td><td>'
                        + '<input type="text" attr-id="' + v.id + '" name="attrs[' + v.id + ']" />'
                        + '</td></tr>';
                    break;
                case 2:
                    var options = '<select attr-id="' + v.id + '" name="attrs[' + v.id + ']">';
                    if (v.attr_values) {
                        $.each(v.attr_values, function (sk, sv) {
                            options += '<option value="' + (sk + 1) + '">' + sv + '</option>';
                        });
                    }
                    options += '</select>';
                    html += '<tr><td>' + v.attr_name + '</td><td>' + options + '</td></tr>';
                    break;
                case 3:
                    html += '<tr><td>' + v.attr_name + '</td><td>'
                        + '<textarea rows="4" attr-id="' + v.id + '" name="attrs[' + v.id + ']"></textarea>'
                        + '</td></tr>';
                    break;
            }
        });
        $("#attr-table").html(html);
    }

    function clearSpecAttr() {
        $("#spec-table").empty();
        $("#attr-table").empty();
        $("#specs-table").empty();
    }

    $("#Pro-model").change(function () {
        var modelid = $(this).val();
        clearSpecAttr();
        if (modelid) {
            var url = $("#getSpecAttr").val();
            var load = layer.load(1, {shade: [0.1, '#CCCCCC'], time: 10000});
            $.post(url, {mid: modelid}, function (response) {
                layer.close(load);
                fillSpecs(response.spec);
                fillAttrs(response.attr);
                if (isEdit) {
                    fillAttrSpecsData();
                }
            });
        }
    });

    function fillSpecsTable() {
        if (alldata.specs) {
            $.each(alldata.specs, function (i, n) {
                $('#price' + n.key).val(n.price);
                $('#inventory' + n.key).val(n.store_count);
                $('#barcode' + n.key).val(n.bar_code);
            });
        }
    }

    function getSpecsTable(specs) {
        var load = layer.load(1, {shade: [0.1, '#CCCCCC'], time: 10000});
        var url = $("#getSpecTable").val();
        $.get(url, {specs: specs}, function (html) {
            layer.close(load);
            $("#specs-table").html(html);
            if (isEdit) {
                fillSpecsTable();
            }
        });
    }

    $("#spec-table").delegate("button", "click", function () {
        $(this).toggleClass('active');
        var specs = [];
        $("#spec-table").find("button").each(function () {
            if ($(this).hasClass('active')) {
                specs.push($(this).attr("spec-id"));
            }
        });
        $("#specs-table").empty();
        if (specs.length > 0) {
            getSpecsTable(specs);
        }
    })

    function getSubCates(catepid) {
        var cates = [];
        $.each(allcates, function (k, v) {
            if (v.pid == catepid) {
                cates.push(v);
            }
        });
        return cates;
    }

    function clearChildrenSelect(e) {
        e.parent().nextAll().find("select").each(function () {
            $(this).find("option:first").siblings().remove();
        });
    }

    $(".cate-select").change(function () {
        clearChildrenSelect($(this));
        var val = $(this).val();
        if (val) {
            var childSelect = $(this).parent().next().find("select");
            var options = '', subcates = getSubCates(val);
            $.each(subcates, function (k, v) {
                options += '<option value="' + v.id + '">' + v.name + '</option>';
            });
            childSelect.append(options);
        }
    });

    // 获取上传图片地址
    function getImages() {
        var images = [];
        $("input[type=hidden][name='thumb_img[]']").each(function () {
            var url = $(this).val();
            if (url) {
                images.push({img_url: url});
            }
        });
        return images;
    }

    function getAttrs() {
        var attrs = [];
        $("#attr-table").find("input, select, textarea").each(function () {
            attrs.push({
                attr_id: $(this).attr("attr-id"),
                attr_value: $(this).val()
            });
        });
        return attrs;
    }

    function getSpecs() {
        var specs = [];
        $("#specs-table").find("input[name^=price]").each(function () {
            var name = $(this).attr('name');
            var key = name.slice(name.indexOf('[') + 1, name.indexOf(']'));
            specs.push({
                'key': key,
                'key_name': $(this).attr('title'),
                'price': $('#price' + key).val(),
                'store_count': $('#inventory' + key).val(),
                'bar_code': $('#barcode' + key).val(),
            });
        });
        return specs;
    }

    function collectGoodsData() {
        var data = {}, cateid = '';
        if (isEdit) {
            data['id'] = $("input[name=id]").val();
        }
        $("#tab1").find("input[type=text], select").each(function () {
            data[$(this).attr("name")] = $(this).val();
        });
        $("#tab1").find("input[type=radio]:checked").each(function () {
            data[$(this).attr("name")] = $(this).val();
        });
        data['category_id'] = data.cate3 ? data.cate3 : (data.cate2 ? data.cate2 : data.cate1);
        delete data.cate1, delete data.cate2, delete data.cate3;
        data['model_id'] = $("#Pro-model").val();
        data['desc'] = UE.getEditor('editor').getContent();
        data['images'] = getImages();
        data['attrs'] = getAttrs();
        data['specs'] = getSpecs();
        return data;
    }

    $("#save-form").click(function () {
        if (!$("#goods-form").valid()) {
            return false;
        }
        var url = $("#goods-form").attr("action"), data = collectGoodsData();
        $.post(url, data, function (response) {
            if (response.status == "success") {
                layer.msg('添加成功', {icon: 1});
                location.href = $("#listUrl").val();
            } else {
                var message = '添加失败！';
                if (response.message) {
                    message = response.message;
                }
                layer.msg(message, {icon: 2});
            }
        });

    });

    init();

});