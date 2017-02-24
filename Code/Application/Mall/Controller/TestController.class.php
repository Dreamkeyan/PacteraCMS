<?php
namespace Mall\Controller;

use Think\Exception;

class TestController extends MobileBaseController
{
    public function index()
    {
        
        dd($_SESSION);
    }
    
    public function cacheTest() {
        $l = 'jjjjdhhfhdksafhka';
        echo "cacheTest";
        S('test', $l);
        echo S('test');
    }
    
    public function cityinfo() {
        $province = M('Province')->select();
        $city     = M('City')->select();
        $county   = M('County')->select();

        $province_list = array();
        $city_list = array();
        $county_list = array();
        foreach ($province as $key => $value) {
            $item = [];
            $item['name'] = $value['province_name'];
            $item['code'] = $value['province_id'];
            $province_list[] = $item;
        }

        foreach ($county as $key => $value) {
            $item = [];
            $item['name'] = $value['county_name'];
            $item['code'] = $value['county_id'];
            if(!array_key_exists($value['city_id'], $county_list)){
                $county_list[$value['city_id']] = [];
            }
            $county_list[$value['city_id']][] = $item;
        }
        array_walk($city, function(&$value, $key) use ($county_list) {
            if(isset($county_list[$value['city_id']])){
                $value['sub'] = $county_list[$value['city_id']];
            }
            
        });
        
        foreach ($city as $key => $value) {
            $item = [];
            $item['name'] = $value['city_name'];
            $item['code'] = $value['city_id'];
            $item['sub'] = $value['sub'];
            if(!array_key_exists($value['province_id'], $city_list)){
                $city_list[$value['province_id']] = [];
            }
            $city_list[$value['province_id']][] = $item;
        }
        
        array_walk($province_list, function(&$value, $key) use ($city_list) {
            if(isset($city_list[$value['code']])){
                $value['sub'] = $city_list[$value['code']];
            }
            
        });
        echo json_encode($province_list);
    }
    
    public function cityinsert() {
        $city_str = [
        array(
            "name"=> "北京",
            "code"=> "110000",
            "sub"=> [
                array(
                    "name"=> "北京市",
                    "code"=> "110000",
                    "sub"=> [
                        array(
                            "name"=> "东城区",
                            "code"=> "110101"
                        ),
                        array(
                            "name"=> "西城区",
                            "code"=> "110102"
                        ),
                        array(
                            "name"=> "朝阳区",
                            "code"=> "110105"
                        ),
                        array(
                            "name"=> "丰台区",
                            "code"=> "110106"
                        ),
                        array(
                            "name"=> "石景山区",
                            "code"=> "110107"
                        ),
                        array(
                            "name"=> "海淀区",
                            "code"=> "110108"
                        ),
                        array(
                            "name"=> "门头沟区",
                            "code"=> "110109"
                        ),
                        array(
                            "name"=> "房山区",
                            "code"=> "110111"
                        ),
                        array(
                            "name"=> "通州区",
                            "code"=> "110112"
                        ),
                        array(
                            "name"=> "顺义区",
                            "code"=> "110113"
                        ),
                        array(
                            "name"=> "昌平区",
                            "code"=> "110114"
                        ),
                        array(
                            "name"=> "大兴区",
                            "code"=> "110115"
                        ),
                        array(
                            "name"=> "怀柔区",
                            "code"=> "110116"
                        ),
                        array(
                            "name"=> "平谷区",
                            "code"=> "110117"
                        ),
                        array(
                            "name"=> "密云县",
                            "code"=> "110228"
                        ),
                        array(
                            "name"=> "延庆县",
                            "code"=> "110229"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "天津",
            "code"=> "120000",
            "sub"=> [
                array(
                    "name"=> "天津市",
                    "code"=> "120000",
                    "sub"=> [
                        array(
                            "name"=> "和平区",
                            "code"=> "120101"
                        ),
                        array(
                            "name"=> "河东区",
                            "code"=> "120102"
                        ),
                        array(
                            "name"=> "河西区",
                            "code"=> "120103"
                        ),
                        array(
                            "name"=> "南开区",
                            "code"=> "120104"
                        ),
                        array(
                            "name"=> "河北区",
                            "code"=> "120105"
                        ),
                        array(
                            "name"=> "红桥区",
                            "code"=> "120106"
                        ),
                        array(
                            "name"=> "东丽区",
                            "code"=> "120110"
                        ),
                        array(
                            "name"=> "西青区",
                            "code"=> "120111"
                        ),
                        array(
                            "name"=> "津南区",
                            "code"=> "120112"
                        ),
                        array(
                            "name"=> "北辰区",
                            "code"=> "120113"
                        ),
                        array(
                            "name"=> "武清区",
                            "code"=> "120114"
                        ),
                        array(
                            "name"=> "宝坻区",
                            "code"=> "120115"
                        ),
                        array(
                            "name"=> "滨海新区",
                            "code"=> "120116"
                        ),
                        array(
                            "name"=> "宁河县",
                            "code"=> "120221"
                        ),
                        array(
                            "name"=> "静海县",
                            "code"=> "120223"
                        ),
                        array(
                            "name"=> "蓟县",
                            "code"=> "120225"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "河北省",
            "code"=> "130000",
            "sub"=> [
                array(
                    "name"=> "石家庄市",
                    "code"=> "130100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130101"
                        ),
                        array(
                            "name"=> "长安区",
                            "code"=> "130102"
                        ),
                        array(
                            "name"=> "桥西区",
                            "code"=> "130104"
                        ),
                        array(
                            "name"=> "新华区",
                            "code"=> "130105"
                        ),
                        array(
                            "name"=> "井陉矿区",
                            "code"=> "130107"
                        ),
                        array(
                            "name"=> "裕华区",
                            "code"=> "130108"
                        ),
                        array(
                            "name"=> "藁城区",
                            "code"=> "130109"
                        ),
                        array(
                            "name"=> "鹿泉区",
                            "code"=> "130110"
                        ),
                        array(
                            "name"=> "栾城区",
                            "code"=> "130111"
                        ),
                        array(
                            "name"=> "井陉县",
                            "code"=> "130121"
                        ),
                        array(
                            "name"=> "正定县",
                            "code"=> "130123"
                        ),
                        array(
                            "name"=> "行唐县",
                            "code"=> "130125"
                        ),
                        array(
                            "name"=> "灵寿县",
                            "code"=> "130126"
                        ),
                        array(
                            "name"=> "高邑县",
                            "code"=> "130127"
                        ),
                        array(
                            "name"=> "深泽县",
                            "code"=> "130128"
                        ),
                        array(
                            "name"=> "赞皇县",
                            "code"=> "130129"
                        ),
                        array(
                            "name"=> "无极县",
                            "code"=> "130130"
                        ),
                        array(
                            "name"=> "平山县",
                            "code"=> "130131"
                        ),
                        array(
                            "name"=> "元氏县",
                            "code"=> "130132"
                        ),
                        array(
                            "name"=> "赵县",
                            "code"=> "130133"
                        ),
                        array(
                            "name"=> "辛集市",
                            "code"=> "130181"
                        ),
                        array(
                            "name"=> "晋州市",
                            "code"=> "130183"
                        ),
                        array(
                            "name"=> "新乐市",
                            "code"=> "130184"
                        )
                    ]
                ),
                array(
                    "name"=> "唐山市",
                    "code"=> "130200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130201"
                        ),
                        array(
                            "name"=> "路南区",
                            "code"=> "130202"
                        ),
                        array(
                            "name"=> "路北区",
                            "code"=> "130203"
                        ),
                        array(
                            "name"=> "古冶区",
                            "code"=> "130204"
                        ),
                        array(
                            "name"=> "开平区",
                            "code"=> "130205"
                        ),
                        array(
                            "name"=> "丰南区",
                            "code"=> "130207"
                        ),
                        array(
                            "name"=> "丰润区",
                            "code"=> "130208"
                        ),
                        array(
                            "name"=> "曹妃甸区",
                            "code"=> "130209"
                        ),
                        array(
                            "name"=> "滦县",
                            "code"=> "130223"
                        ),
                        array(
                            "name"=> "滦南县",
                            "code"=> "130224"
                        ),
                        array(
                            "name"=> "乐亭县",
                            "code"=> "130225"
                        ),
                        array(
                            "name"=> "迁西县",
                            "code"=> "130227"
                        ),
                        array(
                            "name"=> "玉田县",
                            "code"=> "130229"
                        ),
                        array(
                            "name"=> "遵化市",
                            "code"=> "130281"
                        ),
                        array(
                            "name"=> "迁安市",
                            "code"=> "130283"
                        )
                    ]
                ),
                array(
                    "name"=> "秦皇岛市",
                    "code"=> "130300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130301"
                        ),
                        array(
                            "name"=> "海港区",
                            "code"=> "130302"
                        ),
                        array(
                            "name"=> "山海关区",
                            "code"=> "130303"
                        ),
                        array(
                            "name"=> "北戴河区",
                            "code"=> "130304"
                        ),
                        array(
                            "name"=> "青龙满族自治县",
                            "code"=> "130321"
                        ),
                        array(
                            "name"=> "昌黎县",
                            "code"=> "130322"
                        ),
                        array(
                            "name"=> "抚宁县",
                            "code"=> "130323"
                        ),
                        array(
                            "name"=> "卢龙县",
                            "code"=> "130324"
                        )
                    ]
                ),
                array(
                    "name"=> "邯郸市",
                    "code"=> "130400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130401"
                        ),
                        array(
                            "name"=> "邯山区",
                            "code"=> "130402"
                        ),
                        array(
                            "name"=> "丛台区",
                            "code"=> "130403"
                        ),
                        array(
                            "name"=> "复兴区",
                            "code"=> "130404"
                        ),
                        array(
                            "name"=> "峰峰矿区",
                            "code"=> "130406"
                        ),
                        array(
                            "name"=> "邯郸县",
                            "code"=> "130421"
                        ),
                        array(
                            "name"=> "临漳县",
                            "code"=> "130423"
                        ),
                        array(
                            "name"=> "成安县",
                            "code"=> "130424"
                        ),
                        array(
                            "name"=> "大名县",
                            "code"=> "130425"
                        ),
                        array(
                            "name"=> "涉县",
                            "code"=> "130426"
                        ),
                        array(
                            "name"=> "磁县",
                            "code"=> "130427"
                        ),
                        array(
                            "name"=> "肥乡县",
                            "code"=> "130428"
                        ),
                        array(
                            "name"=> "永年县",
                            "code"=> "130429"
                        ),
                        array(
                            "name"=> "邱县",
                            "code"=> "130430"
                        ),
                        array(
                            "name"=> "鸡泽县",
                            "code"=> "130431"
                        ),
                        array(
                            "name"=> "广平县",
                            "code"=> "130432"
                        ),
                        array(
                            "name"=> "馆陶县",
                            "code"=> "130433"
                        ),
                        array(
                            "name"=> "魏县",
                            "code"=> "130434"
                        ),
                        array(
                            "name"=> "曲周县",
                            "code"=> "130435"
                        ),
                        array(
                            "name"=> "武安市",
                            "code"=> "130481"
                        )
                    ]
                ),
                array(
                    "name"=> "邢台市",
                    "code"=> "130500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130501"
                        ),
                        array(
                            "name"=> "桥东区",
                            "code"=> "130502"
                        ),
                        array(
                            "name"=> "桥西区",
                            "code"=> "130503"
                        ),
                        array(
                            "name"=> "邢台县",
                            "code"=> "130521"
                        ),
                        array(
                            "name"=> "临城县",
                            "code"=> "130522"
                        ),
                        array(
                            "name"=> "内丘县",
                            "code"=> "130523"
                        ),
                        array(
                            "name"=> "柏乡县",
                            "code"=> "130524"
                        ),
                        array(
                            "name"=> "隆尧县",
                            "code"=> "130525"
                        ),
                        array(
                            "name"=> "任县",
                            "code"=> "130526"
                        ),
                        array(
                            "name"=> "南和县",
                            "code"=> "130527"
                        ),
                        array(
                            "name"=> "宁晋县",
                            "code"=> "130528"
                        ),
                        array(
                            "name"=> "巨鹿县",
                            "code"=> "130529"
                        ),
                        array(
                            "name"=> "新河县",
                            "code"=> "130530"
                        ),
                        array(
                            "name"=> "广宗县",
                            "code"=> "130531"
                        ),
                        array(
                            "name"=> "平乡县",
                            "code"=> "130532"
                        ),
                        array(
                            "name"=> "威县",
                            "code"=> "130533"
                        ),
                        array(
                            "name"=> "清河县",
                            "code"=> "130534"
                        ),
                        array(
                            "name"=> "临西县",
                            "code"=> "130535"
                        ),
                        array(
                            "name"=> "南宫市",
                            "code"=> "130581"
                        ),
                        array(
                            "name"=> "沙河市",
                            "code"=> "130582"
                        )
                    ]
                ),
                array(
                    "name"=> "保定市",
                    "code"=> "130600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130601"
                        ),
                        array(
                            "name"=> "新市区",
                            "code"=> "130602"
                        ),
                        array(
                            "name"=> "北市区",
                            "code"=> "130603"
                        ),
                        array(
                            "name"=> "南市区",
                            "code"=> "130604"
                        ),
                        array(
                            "name"=> "满城县",
                            "code"=> "130621"
                        ),
                        array(
                            "name"=> "清苑县",
                            "code"=> "130622"
                        ),
                        array(
                            "name"=> "涞水县",
                            "code"=> "130623"
                        ),
                        array(
                            "name"=> "阜平县",
                            "code"=> "130624"
                        ),
                        array(
                            "name"=> "徐水县",
                            "code"=> "130625"
                        ),
                        array(
                            "name"=> "定兴县",
                            "code"=> "130626"
                        ),
                        array(
                            "name"=> "唐县",
                            "code"=> "130627"
                        ),
                        array(
                            "name"=> "高阳县",
                            "code"=> "130628"
                        ),
                        array(
                            "name"=> "容城县",
                            "code"=> "130629"
                        ),
                        array(
                            "name"=> "涞源县",
                            "code"=> "130630"
                        ),
                        array(
                            "name"=> "望都县",
                            "code"=> "130631"
                        ),
                        array(
                            "name"=> "安新县",
                            "code"=> "130632"
                        ),
                        array(
                            "name"=> "易县",
                            "code"=> "130633"
                        ),
                        array(
                            "name"=> "曲阳县",
                            "code"=> "130634"
                        ),
                        array(
                            "name"=> "蠡县",
                            "code"=> "130635"
                        ),
                        array(
                            "name"=> "顺平县",
                            "code"=> "130636"
                        ),
                        array(
                            "name"=> "博野县",
                            "code"=> "130637"
                        ),
                        array(
                            "name"=> "雄县",
                            "code"=> "130638"
                        ),
                        array(
                            "name"=> "涿州市",
                            "code"=> "130681"
                        ),
                        array(
                            "name"=> "定州市",
                            "code"=> "130682"
                        ),
                        array(
                            "name"=> "安国市",
                            "code"=> "130683"
                        ),
                        array(
                            "name"=> "高碑店市",
                            "code"=> "130684"
                        )
                    ]
                ),
                array(
                    "name"=> "张家口市",
                    "code"=> "130700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130701"
                        ),
                        array(
                            "name"=> "桥东区",
                            "code"=> "130702"
                        ),
                        array(
                            "name"=> "桥西区",
                            "code"=> "130703"
                        ),
                        array(
                            "name"=> "宣化区",
                            "code"=> "130705"
                        ),
                        array(
                            "name"=> "下花园区",
                            "code"=> "130706"
                        ),
                        array(
                            "name"=> "宣化县",
                            "code"=> "130721"
                        ),
                        array(
                            "name"=> "张北县",
                            "code"=> "130722"
                        ),
                        array(
                            "name"=> "康保县",
                            "code"=> "130723"
                        ),
                        array(
                            "name"=> "沽源县",
                            "code"=> "130724"
                        ),
                        array(
                            "name"=> "尚义县",
                            "code"=> "130725"
                        ),
                        array(
                            "name"=> "蔚县",
                            "code"=> "130726"
                        ),
                        array(
                            "name"=> "阳原县",
                            "code"=> "130727"
                        ),
                        array(
                            "name"=> "怀安县",
                            "code"=> "130728"
                        ),
                        array(
                            "name"=> "万全县",
                            "code"=> "130729"
                        ),
                        array(
                            "name"=> "怀来县",
                            "code"=> "130730"
                        ),
                        array(
                            "name"=> "涿鹿县",
                            "code"=> "130731"
                        ),
                        array(
                            "name"=> "赤城县",
                            "code"=> "130732"
                        ),
                        array(
                            "name"=> "崇礼县",
                            "code"=> "130733"
                        )
                    ]
                ),
                array(
                    "name"=> "承德市",
                    "code"=> "130800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130801"
                        ),
                        array(
                            "name"=> "双桥区",
                            "code"=> "130802"
                        ),
                        array(
                            "name"=> "双滦区",
                            "code"=> "130803"
                        ),
                        array(
                            "name"=> "鹰手营子矿区",
                            "code"=> "130804"
                        ),
                        array(
                            "name"=> "承德县",
                            "code"=> "130821"
                        ),
                        array(
                            "name"=> "兴隆县",
                            "code"=> "130822"
                        ),
                        array(
                            "name"=> "平泉县",
                            "code"=> "130823"
                        ),
                        array(
                            "name"=> "滦平县",
                            "code"=> "130824"
                        ),
                        array(
                            "name"=> "隆化县",
                            "code"=> "130825"
                        ),
                        array(
                            "name"=> "丰宁满族自治县",
                            "code"=> "130826"
                        ),
                        array(
                            "name"=> "宽城满族自治县",
                            "code"=> "130827"
                        ),
                        array(
                            "name"=> "围场满族蒙古族自治县",
                            "code"=> "130828"
                        )
                    ]
                ),
                array(
                    "name"=> "沧州市",
                    "code"=> "130900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "130901"
                        ),
                        array(
                            "name"=> "新华区",
                            "code"=> "130902"
                        ),
                        array(
                            "name"=> "运河区",
                            "code"=> "130903"
                        ),
                        array(
                            "name"=> "沧县",
                            "code"=> "130921"
                        ),
                        array(
                            "name"=> "青县",
                            "code"=> "130922"
                        ),
                        array(
                            "name"=> "东光县",
                            "code"=> "130923"
                        ),
                        array(
                            "name"=> "海兴县",
                            "code"=> "130924"
                        ),
                        array(
                            "name"=> "盐山县",
                            "code"=> "130925"
                        ),
                        array(
                            "name"=> "肃宁县",
                            "code"=> "130926"
                        ),
                        array(
                            "name"=> "南皮县",
                            "code"=> "130927"
                        ),
                        array(
                            "name"=> "吴桥县",
                            "code"=> "130928"
                        ),
                        array(
                            "name"=> "献县",
                            "code"=> "130929"
                        ),
                        array(
                            "name"=> "孟村回族自治县",
                            "code"=> "130930"
                        ),
                        array(
                            "name"=> "泊头市",
                            "code"=> "130981"
                        ),
                        array(
                            "name"=> "任丘市",
                            "code"=> "130982"
                        ),
                        array(
                            "name"=> "黄骅市",
                            "code"=> "130983"
                        ),
                        array(
                            "name"=> "河间市",
                            "code"=> "130984"
                        )
                    ]
                ),
                array(
                    "name"=> "廊坊市",
                    "code"=> "131000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "131001"
                        ),
                        array(
                            "name"=> "安次区",
                            "code"=> "131002"
                        ),
                        array(
                            "name"=> "广阳区",
                            "code"=> "131003"
                        ),
                        array(
                            "name"=> "固安县",
                            "code"=> "131022"
                        ),
                        array(
                            "name"=> "永清县",
                            "code"=> "131023"
                        ),
                        array(
                            "name"=> "香河县",
                            "code"=> "131024"
                        ),
                        array(
                            "name"=> "大城县",
                            "code"=> "131025"
                        ),
                        array(
                            "name"=> "文安县",
                            "code"=> "131026"
                        ),
                        array(
                            "name"=> "大厂回族自治县",
                            "code"=> "131028"
                        ),
                        array(
                            "name"=> "霸州市",
                            "code"=> "131081"
                        ),
                        array(
                            "name"=> "三河市",
                            "code"=> "131082"
                        )
                    ]
                ),
                array(
                    "name"=> "衡水市",
                    "code"=> "131100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "131101"
                        ),
                        array(
                            "name"=> "桃城区",
                            "code"=> "131102"
                        ),
                        array(
                            "name"=> "枣强县",
                            "code"=> "131121"
                        ),
                        array(
                            "name"=> "武邑县",
                            "code"=> "131122"
                        ),
                        array(
                            "name"=> "武强县",
                            "code"=> "131123"
                        ),
                        array(
                            "name"=> "饶阳县",
                            "code"=> "131124"
                        ),
                        array(
                            "name"=> "安平县",
                            "code"=> "131125"
                        ),
                        array(
                            "name"=> "故城县",
                            "code"=> "131126"
                        ),
                        array(
                            "name"=> "景县",
                            "code"=> "131127"
                        ),
                        array(
                            "name"=> "阜城县",
                            "code"=> "131128"
                        ),
                        array(
                            "name"=> "冀州市",
                            "code"=> "131181"
                        ),
                        array(
                            "name"=> "深州市",
                            "code"=> "131182"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "山西省",
            "code"=> "140000",
            "sub"=> [
                array(
                    "name"=> "太原市",
                    "code"=> "140100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140101"
                        ),
                        array(
                            "name"=> "小店区",
                            "code"=> "140105"
                        ),
                        array(
                            "name"=> "迎泽区",
                            "code"=> "140106"
                        ),
                        array(
                            "name"=> "杏花岭区",
                            "code"=> "140107"
                        ),
                        array(
                            "name"=> "尖草坪区",
                            "code"=> "140108"
                        ),
                        array(
                            "name"=> "万柏林区",
                            "code"=> "140109"
                        ),
                        array(
                            "name"=> "晋源区",
                            "code"=> "140110"
                        ),
                        array(
                            "name"=> "清徐县",
                            "code"=> "140121"
                        ),
                        array(
                            "name"=> "阳曲县",
                            "code"=> "140122"
                        ),
                        array(
                            "name"=> "娄烦县",
                            "code"=> "140123"
                        ),
                        array(
                            "name"=> "古交市",
                            "code"=> "140181"
                        )
                    ]
                ),
                array(
                    "name"=> "大同市",
                    "code"=> "140200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140201"
                        ),
                        array(
                            "name"=> "城区",
                            "code"=> "140202"
                        ),
                        array(
                            "name"=> "矿区",
                            "code"=> "140203"
                        ),
                        array(
                            "name"=> "南郊区",
                            "code"=> "140211"
                        ),
                        array(
                            "name"=> "新荣区",
                            "code"=> "140212"
                        ),
                        array(
                            "name"=> "阳高县",
                            "code"=> "140221"
                        ),
                        array(
                            "name"=> "天镇县",
                            "code"=> "140222"
                        ),
                        array(
                            "name"=> "广灵县",
                            "code"=> "140223"
                        ),
                        array(
                            "name"=> "灵丘县",
                            "code"=> "140224"
                        ),
                        array(
                            "name"=> "浑源县",
                            "code"=> "140225"
                        ),
                        array(
                            "name"=> "左云县",
                            "code"=> "140226"
                        ),
                        array(
                            "name"=> "大同县",
                            "code"=> "140227"
                        )
                    ]
                ),
                array(
                    "name"=> "阳泉市",
                    "code"=> "140300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140301"
                        ),
                        array(
                            "name"=> "城区",
                            "code"=> "140302"
                        ),
                        array(
                            "name"=> "矿区",
                            "code"=> "140303"
                        ),
                        array(
                            "name"=> "郊区",
                            "code"=> "140311"
                        ),
                        array(
                            "name"=> "平定县",
                            "code"=> "140321"
                        ),
                        array(
                            "name"=> "盂县",
                            "code"=> "140322"
                        )
                    ]
                ),
                array(
                    "name"=> "长治市",
                    "code"=> "140400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140401"
                        ),
                        array(
                            "name"=> "城区",
                            "code"=> "140402"
                        ),
                        array(
                            "name"=> "郊区",
                            "code"=> "140411"
                        ),
                        array(
                            "name"=> "长治县",
                            "code"=> "140421"
                        ),
                        array(
                            "name"=> "襄垣县",
                            "code"=> "140423"
                        ),
                        array(
                            "name"=> "屯留县",
                            "code"=> "140424"
                        ),
                        array(
                            "name"=> "平顺县",
                            "code"=> "140425"
                        ),
                        array(
                            "name"=> "黎城县",
                            "code"=> "140426"
                        ),
                        array(
                            "name"=> "壶关县",
                            "code"=> "140427"
                        ),
                        array(
                            "name"=> "长子县",
                            "code"=> "140428"
                        ),
                        array(
                            "name"=> "武乡县",
                            "code"=> "140429"
                        ),
                        array(
                            "name"=> "沁县",
                            "code"=> "140430"
                        ),
                        array(
                            "name"=> "沁源县",
                            "code"=> "140431"
                        ),
                        array(
                            "name"=> "潞城市",
                            "code"=> "140481"
                        )
                    ]
                ),
                array(
                    "name"=> "晋城市",
                    "code"=> "140500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140501"
                        ),
                        array(
                            "name"=> "城区",
                            "code"=> "140502"
                        ),
                        array(
                            "name"=> "沁水县",
                            "code"=> "140521"
                        ),
                        array(
                            "name"=> "阳城县",
                            "code"=> "140522"
                        ),
                        array(
                            "name"=> "陵川县",
                            "code"=> "140524"
                        ),
                        array(
                            "name"=> "泽州县",
                            "code"=> "140525"
                        ),
                        array(
                            "name"=> "高平市",
                            "code"=> "140581"
                        )
                    ]
                ),
                array(
                    "name"=> "朔州市",
                    "code"=> "140600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140601"
                        ),
                        array(
                            "name"=> "朔城区",
                            "code"=> "140602"
                        ),
                        array(
                            "name"=> "平鲁区",
                            "code"=> "140603"
                        ),
                        array(
                            "name"=> "山阴县",
                            "code"=> "140621"
                        ),
                        array(
                            "name"=> "应县",
                            "code"=> "140622"
                        ),
                        array(
                            "name"=> "右玉县",
                            "code"=> "140623"
                        ),
                        array(
                            "name"=> "怀仁县",
                            "code"=> "140624"
                        )
                    ]
                ),
                array(
                    "name"=> "晋中市",
                    "code"=> "140700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140701"
                        ),
                        array(
                            "name"=> "榆次区",
                            "code"=> "140702"
                        ),
                        array(
                            "name"=> "榆社县",
                            "code"=> "140721"
                        ),
                        array(
                            "name"=> "左权县",
                            "code"=> "140722"
                        ),
                        array(
                            "name"=> "和顺县",
                            "code"=> "140723"
                        ),
                        array(
                            "name"=> "昔阳县",
                            "code"=> "140724"
                        ),
                        array(
                            "name"=> "寿阳县",
                            "code"=> "140725"
                        ),
                        array(
                            "name"=> "太谷县",
                            "code"=> "140726"
                        ),
                        array(
                            "name"=> "祁县",
                            "code"=> "140727"
                        ),
                        array(
                            "name"=> "平遥县",
                            "code"=> "140728"
                        ),
                        array(
                            "name"=> "灵石县",
                            "code"=> "140729"
                        ),
                        array(
                            "name"=> "介休市",
                            "code"=> "140781"
                        )
                    ]
                ),
                array(
                    "name"=> "运城市",
                    "code"=> "140800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140801"
                        ),
                        array(
                            "name"=> "盐湖区",
                            "code"=> "140802"
                        ),
                        array(
                            "name"=> "临猗县",
                            "code"=> "140821"
                        ),
                        array(
                            "name"=> "万荣县",
                            "code"=> "140822"
                        ),
                        array(
                            "name"=> "闻喜县",
                            "code"=> "140823"
                        ),
                        array(
                            "name"=> "稷山县",
                            "code"=> "140824"
                        ),
                        array(
                            "name"=> "新绛县",
                            "code"=> "140825"
                        ),
                        array(
                            "name"=> "绛县",
                            "code"=> "140826"
                        ),
                        array(
                            "name"=> "垣曲县",
                            "code"=> "140827"
                        ),
                        array(
                            "name"=> "夏县",
                            "code"=> "140828"
                        ),
                        array(
                            "name"=> "平陆县",
                            "code"=> "140829"
                        ),
                        array(
                            "name"=> "芮城县",
                            "code"=> "140830"
                        ),
                        array(
                            "name"=> "永济市",
                            "code"=> "140881"
                        ),
                        array(
                            "name"=> "河津市",
                            "code"=> "140882"
                        )
                    ]
                ),
                array(
                    "name"=> "忻州市",
                    "code"=> "140900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "140901"
                        ),
                        array(
                            "name"=> "忻府区",
                            "code"=> "140902"
                        ),
                        array(
                            "name"=> "定襄县",
                            "code"=> "140921"
                        ),
                        array(
                            "name"=> "五台县",
                            "code"=> "140922"
                        ),
                        array(
                            "name"=> "代县",
                            "code"=> "140923"
                        ),
                        array(
                            "name"=> "繁峙县",
                            "code"=> "140924"
                        ),
                        array(
                            "name"=> "宁武县",
                            "code"=> "140925"
                        ),
                        array(
                            "name"=> "静乐县",
                            "code"=> "140926"
                        ),
                        array(
                            "name"=> "神池县",
                            "code"=> "140927"
                        ),
                        array(
                            "name"=> "五寨县",
                            "code"=> "140928"
                        ),
                        array(
                            "name"=> "岢岚县",
                            "code"=> "140929"
                        ),
                        array(
                            "name"=> "河曲县",
                            "code"=> "140930"
                        ),
                        array(
                            "name"=> "保德县",
                            "code"=> "140931"
                        ),
                        array(
                            "name"=> "偏关县",
                            "code"=> "140932"
                        ),
                        array(
                            "name"=> "原平市",
                            "code"=> "140981"
                        )
                    ]
                ),
                array(
                    "name"=> "临汾市",
                    "code"=> "141000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "141001"
                        ),
                        array(
                            "name"=> "尧都区",
                            "code"=> "141002"
                        ),
                        array(
                            "name"=> "曲沃县",
                            "code"=> "141021"
                        ),
                        array(
                            "name"=> "翼城县",
                            "code"=> "141022"
                        ),
                        array(
                            "name"=> "襄汾县",
                            "code"=> "141023"
                        ),
                        array(
                            "name"=> "洪洞县",
                            "code"=> "141024"
                        ),
                        array(
                            "name"=> "古县",
                            "code"=> "141025"
                        ),
                        array(
                            "name"=> "安泽县",
                            "code"=> "141026"
                        ),
                        array(
                            "name"=> "浮山县",
                            "code"=> "141027"
                        ),
                        array(
                            "name"=> "吉县",
                            "code"=> "141028"
                        ),
                        array(
                            "name"=> "乡宁县",
                            "code"=> "141029"
                        ),
                        array(
                            "name"=> "大宁县",
                            "code"=> "141030"
                        ),
                        array(
                            "name"=> "隰县",
                            "code"=> "141031"
                        ),
                        array(
                            "name"=> "永和县",
                            "code"=> "141032"
                        ),
                        array(
                            "name"=> "蒲县",
                            "code"=> "141033"
                        ),
                        array(
                            "name"=> "汾西县",
                            "code"=> "141034"
                        ),
                        array(
                            "name"=> "侯马市",
                            "code"=> "141081"
                        ),
                        array(
                            "name"=> "霍州市",
                            "code"=> "141082"
                        )
                    ]
                ),
                array(
                    "name"=> "吕梁市",
                    "code"=> "141100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "141101"
                        ),
                        array(
                            "name"=> "离石区",
                            "code"=> "141102"
                        ),
                        array(
                            "name"=> "文水县",
                            "code"=> "141121"
                        ),
                        array(
                            "name"=> "交城县",
                            "code"=> "141122"
                        ),
                        array(
                            "name"=> "兴县",
                            "code"=> "141123"
                        ),
                        array(
                            "name"=> "临县",
                            "code"=> "141124"
                        ),
                        array(
                            "name"=> "柳林县",
                            "code"=> "141125"
                        ),
                        array(
                            "name"=> "石楼县",
                            "code"=> "141126"
                        ),
                        array(
                            "name"=> "岚县",
                            "code"=> "141127"
                        ),
                        array(
                            "name"=> "方山县",
                            "code"=> "141128"
                        ),
                        array(
                            "name"=> "中阳县",
                            "code"=> "141129"
                        ),
                        array(
                            "name"=> "交口县",
                            "code"=> "141130"
                        ),
                        array(
                            "name"=> "孝义市",
                            "code"=> "141181"
                        ),
                        array(
                            "name"=> "汾阳市",
                            "code"=> "141182"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "内蒙古自治区",
            "code"=> "150000",
            "sub"=> [
                array(
                    "name"=> "呼和浩特市",
                    "code"=> "150100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150101"
                        ),
                        array(
                            "name"=> "新城区",
                            "code"=> "150102"
                        ),
                        array(
                            "name"=> "回民区",
                            "code"=> "150103"
                        ),
                        array(
                            "name"=> "玉泉区",
                            "code"=> "150104"
                        ),
                        array(
                            "name"=> "赛罕区",
                            "code"=> "150105"
                        ),
                        array(
                            "name"=> "土默特左旗",
                            "code"=> "150121"
                        ),
                        array(
                            "name"=> "托克托县",
                            "code"=> "150122"
                        ),
                        array(
                            "name"=> "和林格尔县",
                            "code"=> "150123"
                        ),
                        array(
                            "name"=> "清水河县",
                            "code"=> "150124"
                        ),
                        array(
                            "name"=> "武川县",
                            "code"=> "150125"
                        )
                    ]
                ),
                array(
                    "name"=> "包头市",
                    "code"=> "150200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150201"
                        ),
                        array(
                            "name"=> "东河区",
                            "code"=> "150202"
                        ),
                        array(
                            "name"=> "昆都仑区",
                            "code"=> "150203"
                        ),
                        array(
                            "name"=> "青山区",
                            "code"=> "150204"
                        ),
                        array(
                            "name"=> "石拐区",
                            "code"=> "150205"
                        ),
                        array(
                            "name"=> "白云鄂博矿区",
                            "code"=> "150206"
                        ),
                        array(
                            "name"=> "九原区",
                            "code"=> "150207"
                        ),
                        array(
                            "name"=> "土默特右旗",
                            "code"=> "150221"
                        ),
                        array(
                            "name"=> "固阳县",
                            "code"=> "150222"
                        ),
                        array(
                            "name"=> "达尔罕茂明安联合旗",
                            "code"=> "150223"
                        )
                    ]
                ),
                array(
                    "name"=> "乌海市",
                    "code"=> "150300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150301"
                        ),
                        array(
                            "name"=> "海勃湾区",
                            "code"=> "150302"
                        ),
                        array(
                            "name"=> "海南区",
                            "code"=> "150303"
                        ),
                        array(
                            "name"=> "乌达区",
                            "code"=> "150304"
                        )
                    ]
                ),
                array(
                    "name"=> "赤峰市",
                    "code"=> "150400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150401"
                        ),
                        array(
                            "name"=> "红山区",
                            "code"=> "150402"
                        ),
                        array(
                            "name"=> "元宝山区",
                            "code"=> "150403"
                        ),
                        array(
                            "name"=> "松山区",
                            "code"=> "150404"
                        ),
                        array(
                            "name"=> "阿鲁科尔沁旗",
                            "code"=> "150421"
                        ),
                        array(
                            "name"=> "巴林左旗",
                            "code"=> "150422"
                        ),
                        array(
                            "name"=> "巴林右旗",
                            "code"=> "150423"
                        ),
                        array(
                            "name"=> "林西县",
                            "code"=> "150424"
                        ),
                        array(
                            "name"=> "克什克腾旗",
                            "code"=> "150425"
                        ),
                        array(
                            "name"=> "翁牛特旗",
                            "code"=> "150426"
                        ),
                        array(
                            "name"=> "喀喇沁旗",
                            "code"=> "150428"
                        ),
                        array(
                            "name"=> "宁城县",
                            "code"=> "150429"
                        ),
                        array(
                            "name"=> "敖汉旗",
                            "code"=> "150430"
                        )
                    ]
                ),
                array(
                    "name"=> "通辽市",
                    "code"=> "150500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150501"
                        ),
                        array(
                            "name"=> "科尔沁区",
                            "code"=> "150502"
                        ),
                        array(
                            "name"=> "科尔沁左翼中旗",
                            "code"=> "150521"
                        ),
                        array(
                            "name"=> "科尔沁左翼后旗",
                            "code"=> "150522"
                        ),
                        array(
                            "name"=> "开鲁县",
                            "code"=> "150523"
                        ),
                        array(
                            "name"=> "库伦旗",
                            "code"=> "150524"
                        ),
                        array(
                            "name"=> "奈曼旗",
                            "code"=> "150525"
                        ),
                        array(
                            "name"=> "扎鲁特旗",
                            "code"=> "150526"
                        ),
                        array(
                            "name"=> "霍林郭勒市",
                            "code"=> "150581"
                        )
                    ]
                ),
                array(
                    "name"=> "鄂尔多斯市",
                    "code"=> "150600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150601"
                        ),
                        array(
                            "name"=> "东胜区",
                            "code"=> "150602"
                        ),
                        array(
                            "name"=> "达拉特旗",
                            "code"=> "150621"
                        ),
                        array(
                            "name"=> "准格尔旗",
                            "code"=> "150622"
                        ),
                        array(
                            "name"=> "鄂托克前旗",
                            "code"=> "150623"
                        ),
                        array(
                            "name"=> "鄂托克旗",
                            "code"=> "150624"
                        ),
                        array(
                            "name"=> "杭锦旗",
                            "code"=> "150625"
                        ),
                        array(
                            "name"=> "乌审旗",
                            "code"=> "150626"
                        ),
                        array(
                            "name"=> "伊金霍洛旗",
                            "code"=> "150627"
                        )
                    ]
                ),
                array(
                    "name"=> "呼伦贝尔市",
                    "code"=> "150700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150701"
                        ),
                        array(
                            "name"=> "海拉尔区",
                            "code"=> "150702"
                        ),
                        array(
                            "name"=> "扎赉诺尔区",
                            "code"=> "150703"
                        ),
                        array(
                            "name"=> "阿荣旗",
                            "code"=> "150721"
                        ),
                        array(
                            "name"=> "莫力达瓦达斡尔族自治旗",
                            "code"=> "150722"
                        ),
                        array(
                            "name"=> "鄂伦春自治旗",
                            "code"=> "150723"
                        ),
                        array(
                            "name"=> "鄂温克族自治旗",
                            "code"=> "150724"
                        ),
                        array(
                            "name"=> "陈巴尔虎旗",
                            "code"=> "150725"
                        ),
                        array(
                            "name"=> "新巴尔虎左旗",
                            "code"=> "150726"
                        ),
                        array(
                            "name"=> "新巴尔虎右旗",
                            "code"=> "150727"
                        ),
                        array(
                            "name"=> "满洲里市",
                            "code"=> "150781"
                        ),
                        array(
                            "name"=> "牙克石市",
                            "code"=> "150782"
                        ),
                        array(
                            "name"=> "扎兰屯市",
                            "code"=> "150783"
                        ),
                        array(
                            "name"=> "额尔古纳市",
                            "code"=> "150784"
                        ),
                        array(
                            "name"=> "根河市",
                            "code"=> "150785"
                        )
                    ]
                ),
                array(
                    "name"=> "巴彦淖尔市",
                    "code"=> "150800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150801"
                        ),
                        array(
                            "name"=> "临河区",
                            "code"=> "150802"
                        ),
                        array(
                            "name"=> "五原县",
                            "code"=> "150821"
                        ),
                        array(
                            "name"=> "磴口县",
                            "code"=> "150822"
                        ),
                        array(
                            "name"=> "乌拉特前旗",
                            "code"=> "150823"
                        ),
                        array(
                            "name"=> "乌拉特中旗",
                            "code"=> "150824"
                        ),
                        array(
                            "name"=> "乌拉特后旗",
                            "code"=> "150825"
                        ),
                        array(
                            "name"=> "杭锦后旗",
                            "code"=> "150826"
                        )
                    ]
                ),
                array(
                    "name"=> "乌兰察布市",
                    "code"=> "150900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "150901"
                        ),
                        array(
                            "name"=> "集宁区",
                            "code"=> "150902"
                        ),
                        array(
                            "name"=> "卓资县",
                            "code"=> "150921"
                        ),
                        array(
                            "name"=> "化德县",
                            "code"=> "150922"
                        ),
                        array(
                            "name"=> "商都县",
                            "code"=> "150923"
                        ),
                        array(
                            "name"=> "兴和县",
                            "code"=> "150924"
                        ),
                        array(
                            "name"=> "凉城县",
                            "code"=> "150925"
                        ),
                        array(
                            "name"=> "察哈尔右翼前旗",
                            "code"=> "150926"
                        ),
                        array(
                            "name"=> "察哈尔右翼中旗",
                            "code"=> "150927"
                        ),
                        array(
                            "name"=> "察哈尔右翼后旗",
                            "code"=> "150928"
                        ),
                        array(
                            "name"=> "四子王旗",
                            "code"=> "150929"
                        ),
                        array(
                            "name"=> "丰镇市",
                            "code"=> "150981"
                        )
                    ]
                ),
                array(
                    "name"=> "兴安盟",
                    "code"=> "152200",
                    "sub"=> [
                        array(
                            "name"=> "乌兰浩特市",
                            "code"=> "152201"
                        ),
                        array(
                            "name"=> "阿尔山市",
                            "code"=> "152202"
                        ),
                        array(
                            "name"=> "科尔沁右翼前旗",
                            "code"=> "152221"
                        ),
                        array(
                            "name"=> "科尔沁右翼中旗",
                            "code"=> "152222"
                        ),
                        array(
                            "name"=> "扎赉特旗",
                            "code"=> "152223"
                        ),
                        array(
                            "name"=> "突泉县",
                            "code"=> "152224"
                        )
                    ]
                ),
                array(
                    "name"=> "锡林郭勒盟",
                    "code"=> "152500",
                    "sub"=> [
                        array(
                            "name"=> "二连浩特市",
                            "code"=> "152501"
                        ),
                        array(
                            "name"=> "锡林浩特市",
                            "code"=> "152502"
                        ),
                        array(
                            "name"=> "阿巴嘎旗",
                            "code"=> "152522"
                        ),
                        array(
                            "name"=> "苏尼特左旗",
                            "code"=> "152523"
                        ),
                        array(
                            "name"=> "苏尼特右旗",
                            "code"=> "152524"
                        ),
                        array(
                            "name"=> "东乌珠穆沁旗",
                            "code"=> "152525"
                        ),
                        array(
                            "name"=> "西乌珠穆沁旗",
                            "code"=> "152526"
                        ),
                        array(
                            "name"=> "太仆寺旗",
                            "code"=> "152527"
                        ),
                        array(
                            "name"=> "镶黄旗",
                            "code"=> "152528"
                        ),
                        array(
                            "name"=> "正镶白旗",
                            "code"=> "152529"
                        ),
                        array(
                            "name"=> "正蓝旗",
                            "code"=> "152530"
                        ),
                        array(
                            "name"=> "多伦县",
                            "code"=> "152531"
                        )
                    ]
                ),
                array(
                    "name"=> "阿拉善盟",
                    "code"=> "152900",
                    "sub"=> [
                        array(
                            "name"=> "阿拉善左旗",
                            "code"=> "152921"
                        ),
                        array(
                            "name"=> "阿拉善右旗",
                            "code"=> "152922"
                        ),
                        array(
                            "name"=> "额济纳旗",
                            "code"=> "152923"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "辽宁省",
            "code"=> "210000",
            "sub"=> [
                array(
                    "name"=> "沈阳市",
                    "code"=> "210100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210101"
                        ),
                        array(
                            "name"=> "和平区",
                            "code"=> "210102"
                        ),
                        array(
                            "name"=> "沈河区",
                            "code"=> "210103"
                        ),
                        array(
                            "name"=> "大东区",
                            "code"=> "210104"
                        ),
                        array(
                            "name"=> "皇姑区",
                            "code"=> "210105"
                        ),
                        array(
                            "name"=> "铁西区",
                            "code"=> "210106"
                        ),
                        array(
                            "name"=> "苏家屯区",
                            "code"=> "210111"
                        ),
                        array(
                            "name"=> "浑南区",
                            "code"=> "210112"
                        ),
                        array(
                            "name"=> "沈北新区",
                            "code"=> "210113"
                        ),
                        array(
                            "name"=> "于洪区",
                            "code"=> "210114"
                        ),
                        array(
                            "name"=> "辽中县",
                            "code"=> "210122"
                        ),
                        array(
                            "name"=> "康平县",
                            "code"=> "210123"
                        ),
                        array(
                            "name"=> "法库县",
                            "code"=> "210124"
                        ),
                        array(
                            "name"=> "新民市",
                            "code"=> "210181"
                        )
                    ]
                ),
                array(
                    "name"=> "大连市",
                    "code"=> "210200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210201"
                        ),
                        array(
                            "name"=> "中山区",
                            "code"=> "210202"
                        ),
                        array(
                            "name"=> "西岗区",
                            "code"=> "210203"
                        ),
                        array(
                            "name"=> "沙河口区",
                            "code"=> "210204"
                        ),
                        array(
                            "name"=> "甘井子区",
                            "code"=> "210211"
                        ),
                        array(
                            "name"=> "旅顺口区",
                            "code"=> "210212"
                        ),
                        array(
                            "name"=> "金州区",
                            "code"=> "210213"
                        ),
                        array(
                            "name"=> "长海县",
                            "code"=> "210224"
                        ),
                        array(
                            "name"=> "瓦房店市",
                            "code"=> "210281"
                        ),
                        array(
                            "name"=> "普兰店市",
                            "code"=> "210282"
                        ),
                        array(
                            "name"=> "庄河市",
                            "code"=> "210283"
                        )
                    ]
                ),
                array(
                    "name"=> "鞍山市",
                    "code"=> "210300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210301"
                        ),
                        array(
                            "name"=> "铁东区",
                            "code"=> "210302"
                        ),
                        array(
                            "name"=> "铁西区",
                            "code"=> "210303"
                        ),
                        array(
                            "name"=> "立山区",
                            "code"=> "210304"
                        ),
                        array(
                            "name"=> "千山区",
                            "code"=> "210311"
                        ),
                        array(
                            "name"=> "台安县",
                            "code"=> "210321"
                        ),
                        array(
                            "name"=> "岫岩满族自治县",
                            "code"=> "210323"
                        ),
                        array(
                            "name"=> "海城市",
                            "code"=> "210381"
                        )
                    ]
                ),
                array(
                    "name"=> "抚顺市",
                    "code"=> "210400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210401"
                        ),
                        array(
                            "name"=> "新抚区",
                            "code"=> "210402"
                        ),
                        array(
                            "name"=> "东洲区",
                            "code"=> "210403"
                        ),
                        array(
                            "name"=> "望花区",
                            "code"=> "210404"
                        ),
                        array(
                            "name"=> "顺城区",
                            "code"=> "210411"
                        ),
                        array(
                            "name"=> "抚顺县",
                            "code"=> "210421"
                        ),
                        array(
                            "name"=> "新宾满族自治县",
                            "code"=> "210422"
                        ),
                        array(
                            "name"=> "清原满族自治县",
                            "code"=> "210423"
                        )
                    ]
                ),
                array(
                    "name"=> "本溪市",
                    "code"=> "210500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210501"
                        ),
                        array(
                            "name"=> "平山区",
                            "code"=> "210502"
                        ),
                        array(
                            "name"=> "溪湖区",
                            "code"=> "210503"
                        ),
                        array(
                            "name"=> "明山区",
                            "code"=> "210504"
                        ),
                        array(
                            "name"=> "南芬区",
                            "code"=> "210505"
                        ),
                        array(
                            "name"=> "本溪满族自治县",
                            "code"=> "210521"
                        ),
                        array(
                            "name"=> "桓仁满族自治县",
                            "code"=> "210522"
                        )
                    ]
                ),
                array(
                    "name"=> "丹东市",
                    "code"=> "210600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210601"
                        ),
                        array(
                            "name"=> "元宝区",
                            "code"=> "210602"
                        ),
                        array(
                            "name"=> "振兴区",
                            "code"=> "210603"
                        ),
                        array(
                            "name"=> "振安区",
                            "code"=> "210604"
                        ),
                        array(
                            "name"=> "宽甸满族自治县",
                            "code"=> "210624"
                        ),
                        array(
                            "name"=> "东港市",
                            "code"=> "210681"
                        ),
                        array(
                            "name"=> "凤城市",
                            "code"=> "210682"
                        )
                    ]
                ),
                array(
                    "name"=> "锦州市",
                    "code"=> "210700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210701"
                        ),
                        array(
                            "name"=> "古塔区",
                            "code"=> "210702"
                        ),
                        array(
                            "name"=> "凌河区",
                            "code"=> "210703"
                        ),
                        array(
                            "name"=> "太和区",
                            "code"=> "210711"
                        ),
                        array(
                            "name"=> "黑山县",
                            "code"=> "210726"
                        ),
                        array(
                            "name"=> "义县",
                            "code"=> "210727"
                        ),
                        array(
                            "name"=> "凌海市",
                            "code"=> "210781"
                        ),
                        array(
                            "name"=> "北镇市",
                            "code"=> "210782"
                        )
                    ]
                ),
                array(
                    "name"=> "营口市",
                    "code"=> "210800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210801"
                        ),
                        array(
                            "name"=> "站前区",
                            "code"=> "210802"
                        ),
                        array(
                            "name"=> "西市区",
                            "code"=> "210803"
                        ),
                        array(
                            "name"=> "鲅鱼圈区",
                            "code"=> "210804"
                        ),
                        array(
                            "name"=> "老边区",
                            "code"=> "210811"
                        ),
                        array(
                            "name"=> "盖州市",
                            "code"=> "210881"
                        ),
                        array(
                            "name"=> "大石桥市",
                            "code"=> "210882"
                        )
                    ]
                ),
                array(
                    "name"=> "阜新市",
                    "code"=> "210900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "210901"
                        ),
                        array(
                            "name"=> "海州区",
                            "code"=> "210902"
                        ),
                        array(
                            "name"=> "新邱区",
                            "code"=> "210903"
                        ),
                        array(
                            "name"=> "太平区",
                            "code"=> "210904"
                        ),
                        array(
                            "name"=> "清河门区",
                            "code"=> "210905"
                        ),
                        array(
                            "name"=> "细河区",
                            "code"=> "210911"
                        ),
                        array(
                            "name"=> "阜新蒙古族自治县",
                            "code"=> "210921"
                        ),
                        array(
                            "name"=> "彰武县",
                            "code"=> "210922"
                        )
                    ]
                ),
                array(
                    "name"=> "辽阳市",
                    "code"=> "211000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "211001"
                        ),
                        array(
                            "name"=> "白塔区",
                            "code"=> "211002"
                        ),
                        array(
                            "name"=> "文圣区",
                            "code"=> "211003"
                        ),
                        array(
                            "name"=> "宏伟区",
                            "code"=> "211004"
                        ),
                        array(
                            "name"=> "弓长岭区",
                            "code"=> "211005"
                        ),
                        array(
                            "name"=> "太子河区",
                            "code"=> "211011"
                        ),
                        array(
                            "name"=> "辽阳县",
                            "code"=> "211021"
                        ),
                        array(
                            "name"=> "灯塔市",
                            "code"=> "211081"
                        )
                    ]
                ),
                array(
                    "name"=> "盘锦市",
                    "code"=> "211100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "211101"
                        ),
                        array(
                            "name"=> "双台子区",
                            "code"=> "211102"
                        ),
                        array(
                            "name"=> "兴隆台区",
                            "code"=> "211103"
                        ),
                        array(
                            "name"=> "大洼县",
                            "code"=> "211121"
                        ),
                        array(
                            "name"=> "盘山县",
                            "code"=> "211122"
                        )
                    ]
                ),
                array(
                    "name"=> "铁岭市",
                    "code"=> "211200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "211201"
                        ),
                        array(
                            "name"=> "银州区",
                            "code"=> "211202"
                        ),
                        array(
                            "name"=> "清河区",
                            "code"=> "211204"
                        ),
                        array(
                            "name"=> "铁岭县",
                            "code"=> "211221"
                        ),
                        array(
                            "name"=> "西丰县",
                            "code"=> "211223"
                        ),
                        array(
                            "name"=> "昌图县",
                            "code"=> "211224"
                        ),
                        array(
                            "name"=> "调兵山市",
                            "code"=> "211281"
                        ),
                        array(
                            "name"=> "开原市",
                            "code"=> "211282"
                        )
                    ]
                ),
                array(
                    "name"=> "朝阳市",
                    "code"=> "211300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "211301"
                        ),
                        array(
                            "name"=> "双塔区",
                            "code"=> "211302"
                        ),
                        array(
                            "name"=> "龙城区",
                            "code"=> "211303"
                        ),
                        array(
                            "name"=> "朝阳县",
                            "code"=> "211321"
                        ),
                        array(
                            "name"=> "建平县",
                            "code"=> "211322"
                        ),
                        array(
                            "name"=> "喀喇沁左翼蒙古族自治县",
                            "code"=> "211324"
                        ),
                        array(
                            "name"=> "北票市",
                            "code"=> "211381"
                        ),
                        array(
                            "name"=> "凌源市",
                            "code"=> "211382"
                        )
                    ]
                ),
                array(
                    "name"=> "葫芦岛市",
                    "code"=> "211400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "211401"
                        ),
                        array(
                            "name"=> "连山区",
                            "code"=> "211402"
                        ),
                        array(
                            "name"=> "龙港区",
                            "code"=> "211403"
                        ),
                        array(
                            "name"=> "南票区",
                            "code"=> "211404"
                        ),
                        array(
                            "name"=> "绥中县",
                            "code"=> "211421"
                        ),
                        array(
                            "name"=> "建昌县",
                            "code"=> "211422"
                        ),
                        array(
                            "name"=> "兴城市",
                            "code"=> "211481"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "吉林省",
            "code"=> "220000",
            "sub"=> [
                array(
                    "name"=> "长春市",
                    "code"=> "220100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220101"
                        ),
                        array(
                            "name"=> "南关区",
                            "code"=> "220102"
                        ),
                        array(
                            "name"=> "宽城区",
                            "code"=> "220103"
                        ),
                        array(
                            "name"=> "朝阳区",
                            "code"=> "220104"
                        ),
                        array(
                            "name"=> "二道区",
                            "code"=> "220105"
                        ),
                        array(
                            "name"=> "绿园区",
                            "code"=> "220106"
                        ),
                        array(
                            "name"=> "双阳区",
                            "code"=> "220112"
                        ),
                        array(
                            "name"=> "九台区",
                            "code"=> "220113"
                        ),
                        array(
                            "name"=> "农安县",
                            "code"=> "220122"
                        ),
                        array(
                            "name"=> "榆树市",
                            "code"=> "220182"
                        ),
                        array(
                            "name"=> "德惠市",
                            "code"=> "220183"
                        )
                    ]
                ),
                array(
                    "name"=> "吉林市",
                    "code"=> "220200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220201"
                        ),
                        array(
                            "name"=> "昌邑区",
                            "code"=> "220202"
                        ),
                        array(
                            "name"=> "龙潭区",
                            "code"=> "220203"
                        ),
                        array(
                            "name"=> "船营区",
                            "code"=> "220204"
                        ),
                        array(
                            "name"=> "丰满区",
                            "code"=> "220211"
                        ),
                        array(
                            "name"=> "永吉县",
                            "code"=> "220221"
                        ),
                        array(
                            "name"=> "蛟河市",
                            "code"=> "220281"
                        ),
                        array(
                            "name"=> "桦甸市",
                            "code"=> "220282"
                        ),
                        array(
                            "name"=> "舒兰市",
                            "code"=> "220283"
                        ),
                        array(
                            "name"=> "磐石市",
                            "code"=> "220284"
                        )
                    ]
                ),
                array(
                    "name"=> "四平市",
                    "code"=> "220300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220301"
                        ),
                        array(
                            "name"=> "铁西区",
                            "code"=> "220302"
                        ),
                        array(
                            "name"=> "铁东区",
                            "code"=> "220303"
                        ),
                        array(
                            "name"=> "梨树县",
                            "code"=> "220322"
                        ),
                        array(
                            "name"=> "伊通满族自治县",
                            "code"=> "220323"
                        ),
                        array(
                            "name"=> "公主岭市",
                            "code"=> "220381"
                        ),
                        array(
                            "name"=> "双辽市",
                            "code"=> "220382"
                        )
                    ]
                ),
                array(
                    "name"=> "辽源市",
                    "code"=> "220400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220401"
                        ),
                        array(
                            "name"=> "龙山区",
                            "code"=> "220402"
                        ),
                        array(
                            "name"=> "西安区",
                            "code"=> "220403"
                        ),
                        array(
                            "name"=> "东丰县",
                            "code"=> "220421"
                        ),
                        array(
                            "name"=> "东辽县",
                            "code"=> "220422"
                        )
                    ]
                ),
                array(
                    "name"=> "通化市",
                    "code"=> "220500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220501"
                        ),
                        array(
                            "name"=> "东昌区",
                            "code"=> "220502"
                        ),
                        array(
                            "name"=> "二道江区",
                            "code"=> "220503"
                        ),
                        array(
                            "name"=> "通化县",
                            "code"=> "220521"
                        ),
                        array(
                            "name"=> "辉南县",
                            "code"=> "220523"
                        ),
                        array(
                            "name"=> "柳河县",
                            "code"=> "220524"
                        ),
                        array(
                            "name"=> "梅河口市",
                            "code"=> "220581"
                        ),
                        array(
                            "name"=> "集安市",
                            "code"=> "220582"
                        )
                    ]
                ),
                array(
                    "name"=> "白山市",
                    "code"=> "220600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220601"
                        ),
                        array(
                            "name"=> "浑江区",
                            "code"=> "220602"
                        ),
                        array(
                            "name"=> "江源区",
                            "code"=> "220605"
                        ),
                        array(
                            "name"=> "抚松县",
                            "code"=> "220621"
                        ),
                        array(
                            "name"=> "靖宇县",
                            "code"=> "220622"
                        ),
                        array(
                            "name"=> "长白朝鲜族自治县",
                            "code"=> "220623"
                        ),
                        array(
                            "name"=> "临江市",
                            "code"=> "220681"
                        )
                    ]
                ),
                array(
                    "name"=> "松原市",
                    "code"=> "220700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220701"
                        ),
                        array(
                            "name"=> "宁江区",
                            "code"=> "220702"
                        ),
                        array(
                            "name"=> "前郭尔罗斯蒙古族自治县",
                            "code"=> "220721"
                        ),
                        array(
                            "name"=> "长岭县",
                            "code"=> "220722"
                        ),
                        array(
                            "name"=> "乾安县",
                            "code"=> "220723"
                        ),
                        array(
                            "name"=> "扶余市",
                            "code"=> "220781"
                        )
                    ]
                ),
                array(
                    "name"=> "白城市",
                    "code"=> "220800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "220801"
                        ),
                        array(
                            "name"=> "洮北区",
                            "code"=> "220802"
                        ),
                        array(
                            "name"=> "镇赉县",
                            "code"=> "220821"
                        ),
                        array(
                            "name"=> "通榆县",
                            "code"=> "220822"
                        ),
                        array(
                            "name"=> "洮南市",
                            "code"=> "220881"
                        ),
                        array(
                            "name"=> "大安市",
                            "code"=> "220882"
                        )
                    ]
                ),
                array(
                    "name"=> "延边朝鲜族自治州",
                    "code"=> "222400",
                    "sub"=> [
                        array(
                            "name"=> "延吉市",
                            "code"=> "222401"
                        ),
                        array(
                            "name"=> "图们市",
                            "code"=> "222402"
                        ),
                        array(
                            "name"=> "敦化市",
                            "code"=> "222403"
                        ),
                        array(
                            "name"=> "珲春市",
                            "code"=> "222404"
                        ),
                        array(
                            "name"=> "龙井市",
                            "code"=> "222405"
                        ),
                        array(
                            "name"=> "和龙市",
                            "code"=> "222406"
                        ),
                        array(
                            "name"=> "汪清县",
                            "code"=> "222424"
                        ),
                        array(
                            "name"=> "安图县",
                            "code"=> "222426"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "黑龙江省",
            "code"=> "230000",
            "sub"=> [
                array(
                    "name"=> "哈尔滨市",
                    "code"=> "230100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230101"
                        ),
                        array(
                            "name"=> "道里区",
                            "code"=> "230102"
                        ),
                        array(
                            "name"=> "南岗区",
                            "code"=> "230103"
                        ),
                        array(
                            "name"=> "道外区",
                            "code"=> "230104"
                        ),
                        array(
                            "name"=> "平房区",
                            "code"=> "230108"
                        ),
                        array(
                            "name"=> "松北区",
                            "code"=> "230109"
                        ),
                        array(
                            "name"=> "香坊区",
                            "code"=> "230110"
                        ),
                        array(
                            "name"=> "呼兰区",
                            "code"=> "230111"
                        ),
                        array(
                            "name"=> "阿城区",
                            "code"=> "230112"
                        ),
                        array(
                            "name"=> "双城区",
                            "code"=> "230113"
                        ),
                        array(
                            "name"=> "依兰县",
                            "code"=> "230123"
                        ),
                        array(
                            "name"=> "方正县",
                            "code"=> "230124"
                        ),
                        array(
                            "name"=> "宾县",
                            "code"=> "230125"
                        ),
                        array(
                            "name"=> "巴彦县",
                            "code"=> "230126"
                        ),
                        array(
                            "name"=> "木兰县",
                            "code"=> "230127"
                        ),
                        array(
                            "name"=> "通河县",
                            "code"=> "230128"
                        ),
                        array(
                            "name"=> "延寿县",
                            "code"=> "230129"
                        ),
                        array(
                            "name"=> "尚志市",
                            "code"=> "230183"
                        ),
                        array(
                            "name"=> "五常市",
                            "code"=> "230184"
                        )
                    ]
                ),
                array(
                    "name"=> "齐齐哈尔市",
                    "code"=> "230200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230201"
                        ),
                        array(
                            "name"=> "龙沙区",
                            "code"=> "230202"
                        ),
                        array(
                            "name"=> "建华区",
                            "code"=> "230203"
                        ),
                        array(
                            "name"=> "铁锋区",
                            "code"=> "230204"
                        ),
                        array(
                            "name"=> "昂昂溪区",
                            "code"=> "230205"
                        ),
                        array(
                            "name"=> "富拉尔基区",
                            "code"=> "230206"
                        ),
                        array(
                            "name"=> "碾子山区",
                            "code"=> "230207"
                        ),
                        array(
                            "name"=> "梅里斯达斡尔族区",
                            "code"=> "230208"
                        ),
                        array(
                            "name"=> "龙江县",
                            "code"=> "230221"
                        ),
                        array(
                            "name"=> "依安县",
                            "code"=> "230223"
                        ),
                        array(
                            "name"=> "泰来县",
                            "code"=> "230224"
                        ),
                        array(
                            "name"=> "甘南县",
                            "code"=> "230225"
                        ),
                        array(
                            "name"=> "富裕县",
                            "code"=> "230227"
                        ),
                        array(
                            "name"=> "克山县",
                            "code"=> "230229"
                        ),
                        array(
                            "name"=> "克东县",
                            "code"=> "230230"
                        ),
                        array(
                            "name"=> "拜泉县",
                            "code"=> "230231"
                        ),
                        array(
                            "name"=> "讷河市",
                            "code"=> "230281"
                        )
                    ]
                ),
                array(
                    "name"=> "鸡西市",
                    "code"=> "230300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230301"
                        ),
                        array(
                            "name"=> "鸡冠区",
                            "code"=> "230302"
                        ),
                        array(
                            "name"=> "恒山区",
                            "code"=> "230303"
                        ),
                        array(
                            "name"=> "滴道区",
                            "code"=> "230304"
                        ),
                        array(
                            "name"=> "梨树区",
                            "code"=> "230305"
                        ),
                        array(
                            "name"=> "城子河区",
                            "code"=> "230306"
                        ),
                        array(
                            "name"=> "麻山区",
                            "code"=> "230307"
                        ),
                        array(
                            "name"=> "鸡东县",
                            "code"=> "230321"
                        ),
                        array(
                            "name"=> "虎林市",
                            "code"=> "230381"
                        ),
                        array(
                            "name"=> "密山市",
                            "code"=> "230382"
                        )
                    ]
                ),
                array(
                    "name"=> "鹤岗市",
                    "code"=> "230400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230401"
                        ),
                        array(
                            "name"=> "向阳区",
                            "code"=> "230402"
                        ),
                        array(
                            "name"=> "工农区",
                            "code"=> "230403"
                        ),
                        array(
                            "name"=> "南山区",
                            "code"=> "230404"
                        ),
                        array(
                            "name"=> "兴安区",
                            "code"=> "230405"
                        ),
                        array(
                            "name"=> "东山区",
                            "code"=> "230406"
                        ),
                        array(
                            "name"=> "兴山区",
                            "code"=> "230407"
                        ),
                        array(
                            "name"=> "萝北县",
                            "code"=> "230421"
                        ),
                        array(
                            "name"=> "绥滨县",
                            "code"=> "230422"
                        )
                    ]
                ),
                array(
                    "name"=> "双鸭山市",
                    "code"=> "230500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230501"
                        ),
                        array(
                            "name"=> "尖山区",
                            "code"=> "230502"
                        ),
                        array(
                            "name"=> "岭东区",
                            "code"=> "230503"
                        ),
                        array(
                            "name"=> "四方台区",
                            "code"=> "230505"
                        ),
                        array(
                            "name"=> "宝山区",
                            "code"=> "230506"
                        ),
                        array(
                            "name"=> "集贤县",
                            "code"=> "230521"
                        ),
                        array(
                            "name"=> "友谊县",
                            "code"=> "230522"
                        ),
                        array(
                            "name"=> "宝清县",
                            "code"=> "230523"
                        ),
                        array(
                            "name"=> "饶河县",
                            "code"=> "230524"
                        )
                    ]
                ),
                array(
                    "name"=> "大庆市",
                    "code"=> "230600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230601"
                        ),
                        array(
                            "name"=> "萨尔图区",
                            "code"=> "230602"
                        ),
                        array(
                            "name"=> "龙凤区",
                            "code"=> "230603"
                        ),
                        array(
                            "name"=> "让胡路区",
                            "code"=> "230604"
                        ),
                        array(
                            "name"=> "红岗区",
                            "code"=> "230605"
                        ),
                        array(
                            "name"=> "大同区",
                            "code"=> "230606"
                        ),
                        array(
                            "name"=> "肇州县",
                            "code"=> "230621"
                        ),
                        array(
                            "name"=> "肇源县",
                            "code"=> "230622"
                        ),
                        array(
                            "name"=> "林甸县",
                            "code"=> "230623"
                        ),
                        array(
                            "name"=> "杜尔伯特蒙古族自治县",
                            "code"=> "230624"
                        )
                    ]
                ),
                array(
                    "name"=> "伊春市",
                    "code"=> "230700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230701"
                        ),
                        array(
                            "name"=> "伊春区",
                            "code"=> "230702"
                        ),
                        array(
                            "name"=> "南岔区",
                            "code"=> "230703"
                        ),
                        array(
                            "name"=> "友好区",
                            "code"=> "230704"
                        ),
                        array(
                            "name"=> "西林区",
                            "code"=> "230705"
                        ),
                        array(
                            "name"=> "翠峦区",
                            "code"=> "230706"
                        ),
                        array(
                            "name"=> "新青区",
                            "code"=> "230707"
                        ),
                        array(
                            "name"=> "美溪区",
                            "code"=> "230708"
                        ),
                        array(
                            "name"=> "金山屯区",
                            "code"=> "230709"
                        ),
                        array(
                            "name"=> "五营区",
                            "code"=> "230710"
                        ),
                        array(
                            "name"=> "乌马河区",
                            "code"=> "230711"
                        ),
                        array(
                            "name"=> "汤旺河区",
                            "code"=> "230712"
                        ),
                        array(
                            "name"=> "带岭区",
                            "code"=> "230713"
                        ),
                        array(
                            "name"=> "乌伊岭区",
                            "code"=> "230714"
                        ),
                        array(
                            "name"=> "红星区",
                            "code"=> "230715"
                        ),
                        array(
                            "name"=> "上甘岭区",
                            "code"=> "230716"
                        ),
                        array(
                            "name"=> "嘉荫县",
                            "code"=> "230722"
                        ),
                        array(
                            "name"=> "铁力市",
                            "code"=> "230781"
                        )
                    ]
                ),
                array(
                    "name"=> "佳木斯市",
                    "code"=> "230800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230801"
                        ),
                        array(
                            "name"=> "向阳区",
                            "code"=> "230803"
                        ),
                        array(
                            "name"=> "前进区",
                            "code"=> "230804"
                        ),
                        array(
                            "name"=> "东风区",
                            "code"=> "230805"
                        ),
                        array(
                            "name"=> "郊区",
                            "code"=> "230811"
                        ),
                        array(
                            "name"=> "桦南县",
                            "code"=> "230822"
                        ),
                        array(
                            "name"=> "桦川县",
                            "code"=> "230826"
                        ),
                        array(
                            "name"=> "汤原县",
                            "code"=> "230828"
                        ),
                        array(
                            "name"=> "抚远县",
                            "code"=> "230833"
                        ),
                        array(
                            "name"=> "同江市",
                            "code"=> "230881"
                        ),
                        array(
                            "name"=> "富锦市",
                            "code"=> "230882"
                        )
                    ]
                ),
                array(
                    "name"=> "七台河市",
                    "code"=> "230900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "230901"
                        ),
                        array(
                            "name"=> "新兴区",
                            "code"=> "230902"
                        ),
                        array(
                            "name"=> "桃山区",
                            "code"=> "230903"
                        ),
                        array(
                            "name"=> "茄子河区",
                            "code"=> "230904"
                        ),
                        array(
                            "name"=> "勃利县",
                            "code"=> "230921"
                        )
                    ]
                ),
                array(
                    "name"=> "牡丹江市",
                    "code"=> "231000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "231001"
                        ),
                        array(
                            "name"=> "东安区",
                            "code"=> "231002"
                        ),
                        array(
                            "name"=> "阳明区",
                            "code"=> "231003"
                        ),
                        array(
                            "name"=> "爱民区",
                            "code"=> "231004"
                        ),
                        array(
                            "name"=> "西安区",
                            "code"=> "231005"
                        ),
                        array(
                            "name"=> "东宁县",
                            "code"=> "231024"
                        ),
                        array(
                            "name"=> "林口县",
                            "code"=> "231025"
                        ),
                        array(
                            "name"=> "绥芬河市",
                            "code"=> "231081"
                        ),
                        array(
                            "name"=> "海林市",
                            "code"=> "231083"
                        ),
                        array(
                            "name"=> "宁安市",
                            "code"=> "231084"
                        ),
                        array(
                            "name"=> "穆棱市",
                            "code"=> "231085"
                        )
                    ]
                ),
                array(
                    "name"=> "黑河市",
                    "code"=> "231100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "231101"
                        ),
                        array(
                            "name"=> "爱辉区",
                            "code"=> "231102"
                        ),
                        array(
                            "name"=> "嫩江县",
                            "code"=> "231121"
                        ),
                        array(
                            "name"=> "逊克县",
                            "code"=> "231123"
                        ),
                        array(
                            "name"=> "孙吴县",
                            "code"=> "231124"
                        ),
                        array(
                            "name"=> "北安市",
                            "code"=> "231181"
                        ),
                        array(
                            "name"=> "五大连池市",
                            "code"=> "231182"
                        )
                    ]
                ),
                array(
                    "name"=> "绥化市",
                    "code"=> "231200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "231201"
                        ),
                        array(
                            "name"=> "北林区",
                            "code"=> "231202"
                        ),
                        array(
                            "name"=> "望奎县",
                            "code"=> "231221"
                        ),
                        array(
                            "name"=> "兰西县",
                            "code"=> "231222"
                        ),
                        array(
                            "name"=> "青冈县",
                            "code"=> "231223"
                        ),
                        array(
                            "name"=> "庆安县",
                            "code"=> "231224"
                        ),
                        array(
                            "name"=> "明水县",
                            "code"=> "231225"
                        ),
                        array(
                            "name"=> "绥棱县",
                            "code"=> "231226"
                        ),
                        array(
                            "name"=> "安达市",
                            "code"=> "231281"
                        ),
                        array(
                            "name"=> "肇东市",
                            "code"=> "231282"
                        ),
                        array(
                            "name"=> "海伦市",
                            "code"=> "231283"
                        )
                    ]
                ),
                array(
                    "name"=> "大兴安岭地区",
                    "code"=> "232700",
                    "sub"=> [
                        array(
                            "name"=> "呼玛县",
                            "code"=> "232721"
                        ),
                        array(
                            "name"=> "塔河县",
                            "code"=> "232722"
                        ),
                        array(
                            "name"=> "漠河县",
                            "code"=> "232723"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "上海",
            "code"=> "310000",
            "sub"=> [
                array(
                    "name"=> "上海市",
                    "code"=> "310000",
                    "sub"=> [
                        array(
                            "name"=> "黄浦区",
                            "code"=> "310101"
                        ),
                        array(
                            "name"=> "徐汇区",
                            "code"=> "310104"
                        ),
                        array(
                            "name"=> "长宁区",
                            "code"=> "310105"
                        ),
                        array(
                            "name"=> "静安区",
                            "code"=> "310106"
                        ),
                        array(
                            "name"=> "普陀区",
                            "code"=> "310107"
                        ),
                        array(
                            "name"=> "闸北区",
                            "code"=> "310108"
                        ),
                        array(
                            "name"=> "虹口区",
                            "code"=> "310109"
                        ),
                        array(
                            "name"=> "杨浦区",
                            "code"=> "310110"
                        ),
                        array(
                            "name"=> "闵行区",
                            "code"=> "310112"
                        ),
                        array(
                            "name"=> "宝山区",
                            "code"=> "310113"
                        ),
                        array(
                            "name"=> "嘉定区",
                            "code"=> "310114"
                        ),
                        array(
                            "name"=> "浦东新区",
                            "code"=> "310115"
                        ),
                        array(
                            "name"=> "金山区",
                            "code"=> "310116"
                        ),
                        array(
                            "name"=> "松江区",
                            "code"=> "310117"
                        ),
                        array(
                            "name"=> "青浦区",
                            "code"=> "310118"
                        ),
                        array(
                            "name"=> "奉贤区",
                            "code"=> "310120"
                        ),
                        array(
                            "name"=> "崇明县",
                            "code"=> "310230"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "江苏省",
            "code"=> "320000",
            "sub"=> [
                array(
                    "name"=> "南京市",
                    "code"=> "320100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320101"
                        ),
                        array(
                            "name"=> "玄武区",
                            "code"=> "320102"
                        ),
                        array(
                            "name"=> "秦淮区",
                            "code"=> "320104"
                        ),
                        array(
                            "name"=> "建邺区",
                            "code"=> "320105"
                        ),
                        array(
                            "name"=> "鼓楼区",
                            "code"=> "320106"
                        ),
                        array(
                            "name"=> "浦口区",
                            "code"=> "320111"
                        ),
                        array(
                            "name"=> "栖霞区",
                            "code"=> "320113"
                        ),
                        array(
                            "name"=> "雨花台区",
                            "code"=> "320114"
                        ),
                        array(
                            "name"=> "江宁区",
                            "code"=> "320115"
                        ),
                        array(
                            "name"=> "六合区",
                            "code"=> "320116"
                        ),
                        array(
                            "name"=> "溧水区",
                            "code"=> "320117"
                        ),
                        array(
                            "name"=> "高淳区",
                            "code"=> "320118"
                        )
                    ]
                ),
                array(
                    "name"=> "无锡市",
                    "code"=> "320200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320201"
                        ),
                        array(
                            "name"=> "崇安区",
                            "code"=> "320202"
                        ),
                        array(
                            "name"=> "南长区",
                            "code"=> "320203"
                        ),
                        array(
                            "name"=> "北塘区",
                            "code"=> "320204"
                        ),
                        array(
                            "name"=> "锡山区",
                            "code"=> "320205"
                        ),
                        array(
                            "name"=> "惠山区",
                            "code"=> "320206"
                        ),
                        array(
                            "name"=> "滨湖区",
                            "code"=> "320211"
                        ),
                        array(
                            "name"=> "江阴市",
                            "code"=> "320281"
                        ),
                        array(
                            "name"=> "宜兴市",
                            "code"=> "320282"
                        )
                    ]
                ),
                array(
                    "name"=> "徐州市",
                    "code"=> "320300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320301"
                        ),
                        array(
                            "name"=> "鼓楼区",
                            "code"=> "320302"
                        ),
                        array(
                            "name"=> "云龙区",
                            "code"=> "320303"
                        ),
                        array(
                            "name"=> "贾汪区",
                            "code"=> "320305"
                        ),
                        array(
                            "name"=> "泉山区",
                            "code"=> "320311"
                        ),
                        array(
                            "name"=> "铜山区",
                            "code"=> "320312"
                        ),
                        array(
                            "name"=> "丰县",
                            "code"=> "320321"
                        ),
                        array(
                            "name"=> "沛县",
                            "code"=> "320322"
                        ),
                        array(
                            "name"=> "睢宁县",
                            "code"=> "320324"
                        ),
                        array(
                            "name"=> "新沂市",
                            "code"=> "320381"
                        ),
                        array(
                            "name"=> "邳州市",
                            "code"=> "320382"
                        )
                    ]
                ),
                array(
                    "name"=> "常州市",
                    "code"=> "320400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320401"
                        ),
                        array(
                            "name"=> "天宁区",
                            "code"=> "320402"
                        ),
                        array(
                            "name"=> "钟楼区",
                            "code"=> "320404"
                        ),
                        array(
                            "name"=> "戚墅堰区",
                            "code"=> "320405"
                        ),
                        array(
                            "name"=> "新北区",
                            "code"=> "320411"
                        ),
                        array(
                            "name"=> "武进区",
                            "code"=> "320412"
                        ),
                        array(
                            "name"=> "溧阳市",
                            "code"=> "320481"
                        ),
                        array(
                            "name"=> "金坛市",
                            "code"=> "320482"
                        )
                    ]
                ),
                array(
                    "name"=> "苏州市",
                    "code"=> "320500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320501"
                        ),
                        array(
                            "name"=> "虎丘区",
                            "code"=> "320505"
                        ),
                        array(
                            "name"=> "吴中区",
                            "code"=> "320506"
                        ),
                        array(
                            "name"=> "相城区",
                            "code"=> "320507"
                        ),
                        array(
                            "name"=> "姑苏区",
                            "code"=> "320508"
                        ),
                        array(
                            "name"=> "吴江区",
                            "code"=> "320509"
                        ),
                        array(
                            "name"=> "常熟市",
                            "code"=> "320581"
                        ),
                        array(
                            "name"=> "张家港市",
                            "code"=> "320582"
                        ),
                        array(
                            "name"=> "昆山市",
                            "code"=> "320583"
                        ),
                        array(
                            "name"=> "太仓市",
                            "code"=> "320585"
                        )
                    ]
                ),
                array(
                    "name"=> "南通市",
                    "code"=> "320600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320601"
                        ),
                        array(
                            "name"=> "崇川区",
                            "code"=> "320602"
                        ),
                        array(
                            "name"=> "港闸区",
                            "code"=> "320611"
                        ),
                        array(
                            "name"=> "通州区",
                            "code"=> "320612"
                        ),
                        array(
                            "name"=> "海安县",
                            "code"=> "320621"
                        ),
                        array(
                            "name"=> "如东县",
                            "code"=> "320623"
                        ),
                        array(
                            "name"=> "启东市",
                            "code"=> "320681"
                        ),
                        array(
                            "name"=> "如皋市",
                            "code"=> "320682"
                        ),
                        array(
                            "name"=> "海门市",
                            "code"=> "320684"
                        )
                    ]
                ),
                array(
                    "name"=> "连云港市",
                    "code"=> "320700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320701"
                        ),
                        array(
                            "name"=> "连云区",
                            "code"=> "320703"
                        ),
                        array(
                            "name"=> "海州区",
                            "code"=> "320706"
                        ),
                        array(
                            "name"=> "赣榆区",
                            "code"=> "320707"
                        ),
                        array(
                            "name"=> "东海县",
                            "code"=> "320722"
                        ),
                        array(
                            "name"=> "灌云县",
                            "code"=> "320723"
                        ),
                        array(
                            "name"=> "灌南县",
                            "code"=> "320724"
                        )
                    ]
                ),
                array(
                    "name"=> "淮安市",
                    "code"=> "320800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320801"
                        ),
                        array(
                            "name"=> "清河区",
                            "code"=> "320802"
                        ),
                        array(
                            "name"=> "淮安区",
                            "code"=> "320803"
                        ),
                        array(
                            "name"=> "淮阴区",
                            "code"=> "320804"
                        ),
                        array(
                            "name"=> "清浦区",
                            "code"=> "320811"
                        ),
                        array(
                            "name"=> "涟水县",
                            "code"=> "320826"
                        ),
                        array(
                            "name"=> "洪泽县",
                            "code"=> "320829"
                        ),
                        array(
                            "name"=> "盱眙县",
                            "code"=> "320830"
                        ),
                        array(
                            "name"=> "金湖县",
                            "code"=> "320831"
                        )
                    ]
                ),
                array(
                    "name"=> "盐城市",
                    "code"=> "320900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "320901"
                        ),
                        array(
                            "name"=> "亭湖区",
                            "code"=> "320902"
                        ),
                        array(
                            "name"=> "盐都区",
                            "code"=> "320903"
                        ),
                        array(
                            "name"=> "响水县",
                            "code"=> "320921"
                        ),
                        array(
                            "name"=> "滨海县",
                            "code"=> "320922"
                        ),
                        array(
                            "name"=> "阜宁县",
                            "code"=> "320923"
                        ),
                        array(
                            "name"=> "射阳县",
                            "code"=> "320924"
                        ),
                        array(
                            "name"=> "建湖县",
                            "code"=> "320925"
                        ),
                        array(
                            "name"=> "东台市",
                            "code"=> "320981"
                        ),
                        array(
                            "name"=> "大丰市",
                            "code"=> "320982"
                        )
                    ]
                ),
                array(
                    "name"=> "扬州市",
                    "code"=> "321000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "321001"
                        ),
                        array(
                            "name"=> "广陵区",
                            "code"=> "321002"
                        ),
                        array(
                            "name"=> "邗江区",
                            "code"=> "321003"
                        ),
                        array(
                            "name"=> "江都区",
                            "code"=> "321012"
                        ),
                        array(
                            "name"=> "宝应县",
                            "code"=> "321023"
                        ),
                        array(
                            "name"=> "仪征市",
                            "code"=> "321081"
                        ),
                        array(
                            "name"=> "高邮市",
                            "code"=> "321084"
                        )
                    ]
                ),
                array(
                    "name"=> "镇江市",
                    "code"=> "321100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "321101"
                        ),
                        array(
                            "name"=> "京口区",
                            "code"=> "321102"
                        ),
                        array(
                            "name"=> "润州区",
                            "code"=> "321111"
                        ),
                        array(
                            "name"=> "丹徒区",
                            "code"=> "321112"
                        ),
                        array(
                            "name"=> "丹阳市",
                            "code"=> "321181"
                        ),
                        array(
                            "name"=> "扬中市",
                            "code"=> "321182"
                        ),
                        array(
                            "name"=> "句容市",
                            "code"=> "321183"
                        )
                    ]
                ),
                array(
                    "name"=> "泰州市",
                    "code"=> "321200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "321201"
                        ),
                        array(
                            "name"=> "海陵区",
                            "code"=> "321202"
                        ),
                        array(
                            "name"=> "高港区",
                            "code"=> "321203"
                        ),
                        array(
                            "name"=> "姜堰区",
                            "code"=> "321204"
                        ),
                        array(
                            "name"=> "兴化市",
                            "code"=> "321281"
                        ),
                        array(
                            "name"=> "靖江市",
                            "code"=> "321282"
                        ),
                        array(
                            "name"=> "泰兴市",
                            "code"=> "321283"
                        )
                    ]
                ),
                array(
                    "name"=> "宿迁市",
                    "code"=> "321300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "321301"
                        ),
                        array(
                            "name"=> "宿城区",
                            "code"=> "321302"
                        ),
                        array(
                            "name"=> "宿豫区",
                            "code"=> "321311"
                        ),
                        array(
                            "name"=> "沭阳县",
                            "code"=> "321322"
                        ),
                        array(
                            "name"=> "泗阳县",
                            "code"=> "321323"
                        ),
                        array(
                            "name"=> "泗洪县",
                            "code"=> "321324"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "浙江省",
            "code"=> "330000",
            "sub"=> [
                array(
                    "name"=> "杭州市",
                    "code"=> "330100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330101"
                        ),
                        array(
                            "name"=> "上城区",
                            "code"=> "330102"
                        ),
                        array(
                            "name"=> "下城区",
                            "code"=> "330103"
                        ),
                        array(
                            "name"=> "江干区",
                            "code"=> "330104"
                        ),
                        array(
                            "name"=> "拱墅区",
                            "code"=> "330105"
                        ),
                        array(
                            "name"=> "西湖区",
                            "code"=> "330106"
                        ),
                        array(
                            "name"=> "滨江区",
                            "code"=> "330108"
                        ),
                        array(
                            "name"=> "萧山区",
                            "code"=> "330109"
                        ),
                        array(
                            "name"=> "余杭区",
                            "code"=> "330110"
                        ),
                        array(
                            "name"=> "富阳区",
                            "code"=> "330111"
                        ),
                        array(
                            "name"=> "桐庐县",
                            "code"=> "330122"
                        ),
                        array(
                            "name"=> "淳安县",
                            "code"=> "330127"
                        ),
                        array(
                            "name"=> "建德市",
                            "code"=> "330182"
                        ),
                        array(
                            "name"=> "临安市",
                            "code"=> "330185"
                        )
                    ]
                ),
                array(
                    "name"=> "宁波市",
                    "code"=> "330200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330201"
                        ),
                        array(
                            "name"=> "海曙区",
                            "code"=> "330203"
                        ),
                        array(
                            "name"=> "江东区",
                            "code"=> "330204"
                        ),
                        array(
                            "name"=> "江北区",
                            "code"=> "330205"
                        ),
                        array(
                            "name"=> "北仑区",
                            "code"=> "330206"
                        ),
                        array(
                            "name"=> "镇海区",
                            "code"=> "330211"
                        ),
                        array(
                            "name"=> "鄞州区",
                            "code"=> "330212"
                        ),
                        array(
                            "name"=> "象山县",
                            "code"=> "330225"
                        ),
                        array(
                            "name"=> "宁海县",
                            "code"=> "330226"
                        ),
                        array(
                            "name"=> "余姚市",
                            "code"=> "330281"
                        ),
                        array(
                            "name"=> "慈溪市",
                            "code"=> "330282"
                        ),
                        array(
                            "name"=> "奉化市",
                            "code"=> "330283"
                        )
                    ]
                ),
                array(
                    "name"=> "温州市",
                    "code"=> "330300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330301"
                        ),
                        array(
                            "name"=> "鹿城区",
                            "code"=> "330302"
                        ),
                        array(
                            "name"=> "龙湾区",
                            "code"=> "330303"
                        ),
                        array(
                            "name"=> "瓯海区",
                            "code"=> "330304"
                        ),
                        array(
                            "name"=> "洞头县",
                            "code"=> "330322"
                        ),
                        array(
                            "name"=> "永嘉县",
                            "code"=> "330324"
                        ),
                        array(
                            "name"=> "平阳县",
                            "code"=> "330326"
                        ),
                        array(
                            "name"=> "苍南县",
                            "code"=> "330327"
                        ),
                        array(
                            "name"=> "文成县",
                            "code"=> "330328"
                        ),
                        array(
                            "name"=> "泰顺县",
                            "code"=> "330329"
                        ),
                        array(
                            "name"=> "瑞安市",
                            "code"=> "330381"
                        ),
                        array(
                            "name"=> "乐清市",
                            "code"=> "330382"
                        )
                    ]
                ),
                array(
                    "name"=> "嘉兴市",
                    "code"=> "330400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330401"
                        ),
                        array(
                            "name"=> "南湖区",
                            "code"=> "330402"
                        ),
                        array(
                            "name"=> "秀洲区",
                            "code"=> "330411"
                        ),
                        array(
                            "name"=> "嘉善县",
                            "code"=> "330421"
                        ),
                        array(
                            "name"=> "海盐县",
                            "code"=> "330424"
                        ),
                        array(
                            "name"=> "海宁市",
                            "code"=> "330481"
                        ),
                        array(
                            "name"=> "平湖市",
                            "code"=> "330482"
                        ),
                        array(
                            "name"=> "桐乡市",
                            "code"=> "330483"
                        )
                    ]
                ),
                array(
                    "name"=> "湖州市",
                    "code"=> "330500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330501"
                        ),
                        array(
                            "name"=> "吴兴区",
                            "code"=> "330502"
                        ),
                        array(
                            "name"=> "南浔区",
                            "code"=> "330503"
                        ),
                        array(
                            "name"=> "德清县",
                            "code"=> "330521"
                        ),
                        array(
                            "name"=> "长兴县",
                            "code"=> "330522"
                        ),
                        array(
                            "name"=> "安吉县",
                            "code"=> "330523"
                        )
                    ]
                ),
                array(
                    "name"=> "绍兴市",
                    "code"=> "330600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330601"
                        ),
                        array(
                            "name"=> "越城区",
                            "code"=> "330602"
                        ),
                        array(
                            "name"=> "柯桥区",
                            "code"=> "330603"
                        ),
                        array(
                            "name"=> "上虞区",
                            "code"=> "330604"
                        ),
                        array(
                            "name"=> "新昌县",
                            "code"=> "330624"
                        ),
                        array(
                            "name"=> "诸暨市",
                            "code"=> "330681"
                        ),
                        array(
                            "name"=> "嵊州市",
                            "code"=> "330683"
                        )
                    ]
                ),
                array(
                    "name"=> "金华市",
                    "code"=> "330700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330701"
                        ),
                        array(
                            "name"=> "婺城区",
                            "code"=> "330702"
                        ),
                        array(
                            "name"=> "金东区",
                            "code"=> "330703"
                        ),
                        array(
                            "name"=> "武义县",
                            "code"=> "330723"
                        ),
                        array(
                            "name"=> "浦江县",
                            "code"=> "330726"
                        ),
                        array(
                            "name"=> "磐安县",
                            "code"=> "330727"
                        ),
                        array(
                            "name"=> "兰溪市",
                            "code"=> "330781"
                        ),
                        array(
                            "name"=> "义乌市",
                            "code"=> "330782"
                        ),
                        array(
                            "name"=> "东阳市",
                            "code"=> "330783"
                        ),
                        array(
                            "name"=> "永康市",
                            "code"=> "330784"
                        )
                    ]
                ),
                array(
                    "name"=> "衢州市",
                    "code"=> "330800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330801"
                        ),
                        array(
                            "name"=> "柯城区",
                            "code"=> "330802"
                        ),
                        array(
                            "name"=> "衢江区",
                            "code"=> "330803"
                        ),
                        array(
                            "name"=> "常山县",
                            "code"=> "330822"
                        ),
                        array(
                            "name"=> "开化县",
                            "code"=> "330824"
                        ),
                        array(
                            "name"=> "龙游县",
                            "code"=> "330825"
                        ),
                        array(
                            "name"=> "江山市",
                            "code"=> "330881"
                        )
                    ]
                ),
                array(
                    "name"=> "舟山市",
                    "code"=> "330900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "330901"
                        ),
                        array(
                            "name"=> "定海区",
                            "code"=> "330902"
                        ),
                        array(
                            "name"=> "普陀区",
                            "code"=> "330903"
                        ),
                        array(
                            "name"=> "岱山县",
                            "code"=> "330921"
                        ),
                        array(
                            "name"=> "嵊泗县",
                            "code"=> "330922"
                        )
                    ]
                ),
                array(
                    "name"=> "台州市",
                    "code"=> "331000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "331001"
                        ),
                        array(
                            "name"=> "椒江区",
                            "code"=> "331002"
                        ),
                        array(
                            "name"=> "黄岩区",
                            "code"=> "331003"
                        ),
                        array(
                            "name"=> "路桥区",
                            "code"=> "331004"
                        ),
                        array(
                            "name"=> "玉环县",
                            "code"=> "331021"
                        ),
                        array(
                            "name"=> "三门县",
                            "code"=> "331022"
                        ),
                        array(
                            "name"=> "天台县",
                            "code"=> "331023"
                        ),
                        array(
                            "name"=> "仙居县",
                            "code"=> "331024"
                        ),
                        array(
                            "name"=> "温岭市",
                            "code"=> "331081"
                        ),
                        array(
                            "name"=> "临海市",
                            "code"=> "331082"
                        )
                    ]
                ),
                array(
                    "name"=> "丽水市",
                    "code"=> "331100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "331101"
                        ),
                        array(
                            "name"=> "莲都区",
                            "code"=> "331102"
                        ),
                        array(
                            "name"=> "青田县",
                            "code"=> "331121"
                        ),
                        array(
                            "name"=> "缙云县",
                            "code"=> "331122"
                        ),
                        array(
                            "name"=> "遂昌县",
                            "code"=> "331123"
                        ),
                        array(
                            "name"=> "松阳县",
                            "code"=> "331124"
                        ),
                        array(
                            "name"=> "云和县",
                            "code"=> "331125"
                        ),
                        array(
                            "name"=> "庆元县",
                            "code"=> "331126"
                        ),
                        array(
                            "name"=> "景宁畲族自治县",
                            "code"=> "331127"
                        ),
                        array(
                            "name"=> "龙泉市",
                            "code"=> "331181"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "安徽省",
            "code"=> "340000",
            "sub"=> [
                array(
                    "name"=> "合肥市",
                    "code"=> "340100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340101"
                        ),
                        array(
                            "name"=> "瑶海区",
                            "code"=> "340102"
                        ),
                        array(
                            "name"=> "庐阳区",
                            "code"=> "340103"
                        ),
                        array(
                            "name"=> "蜀山区",
                            "code"=> "340104"
                        ),
                        array(
                            "name"=> "包河区",
                            "code"=> "340111"
                        ),
                        array(
                            "name"=> "长丰县",
                            "code"=> "340121"
                        ),
                        array(
                            "name"=> "肥东县",
                            "code"=> "340122"
                        ),
                        array(
                            "name"=> "肥西县",
                            "code"=> "340123"
                        ),
                        array(
                            "name"=> "庐江县",
                            "code"=> "340124"
                        ),
                        array(
                            "name"=> "巢湖市",
                            "code"=> "340181"
                        )
                    ]
                ),
                array(
                    "name"=> "芜湖市",
                    "code"=> "340200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340201"
                        ),
                        array(
                            "name"=> "镜湖区",
                            "code"=> "340202"
                        ),
                        array(
                            "name"=> "弋江区",
                            "code"=> "340203"
                        ),
                        array(
                            "name"=> "鸠江区",
                            "code"=> "340207"
                        ),
                        array(
                            "name"=> "三山区",
                            "code"=> "340208"
                        ),
                        array(
                            "name"=> "芜湖县",
                            "code"=> "340221"
                        ),
                        array(
                            "name"=> "繁昌县",
                            "code"=> "340222"
                        ),
                        array(
                            "name"=> "南陵县",
                            "code"=> "340223"
                        ),
                        array(
                            "name"=> "无为县",
                            "code"=> "340225"
                        )
                    ]
                ),
                array(
                    "name"=> "蚌埠市",
                    "code"=> "340300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340301"
                        ),
                        array(
                            "name"=> "龙子湖区",
                            "code"=> "340302"
                        ),
                        array(
                            "name"=> "蚌山区",
                            "code"=> "340303"
                        ),
                        array(
                            "name"=> "禹会区",
                            "code"=> "340304"
                        ),
                        array(
                            "name"=> "淮上区",
                            "code"=> "340311"
                        ),
                        array(
                            "name"=> "怀远县",
                            "code"=> "340321"
                        ),
                        array(
                            "name"=> "五河县",
                            "code"=> "340322"
                        ),
                        array(
                            "name"=> "固镇县",
                            "code"=> "340323"
                        )
                    ]
                ),
                array(
                    "name"=> "淮南市",
                    "code"=> "340400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340401"
                        ),
                        array(
                            "name"=> "大通区",
                            "code"=> "340402"
                        ),
                        array(
                            "name"=> "田家庵区",
                            "code"=> "340403"
                        ),
                        array(
                            "name"=> "谢家集区",
                            "code"=> "340404"
                        ),
                        array(
                            "name"=> "八公山区",
                            "code"=> "340405"
                        ),
                        array(
                            "name"=> "潘集区",
                            "code"=> "340406"
                        ),
                        array(
                            "name"=> "凤台县",
                            "code"=> "340421"
                        )
                    ]
                ),
                array(
                    "name"=> "马鞍山市",
                    "code"=> "340500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340501"
                        ),
                        array(
                            "name"=> "花山区",
                            "code"=> "340503"
                        ),
                        array(
                            "name"=> "雨山区",
                            "code"=> "340504"
                        ),
                        array(
                            "name"=> "博望区",
                            "code"=> "340506"
                        ),
                        array(
                            "name"=> "当涂县",
                            "code"=> "340521"
                        ),
                        array(
                            "name"=> "含山县",
                            "code"=> "340522"
                        ),
                        array(
                            "name"=> "和县",
                            "code"=> "340523"
                        )
                    ]
                ),
                array(
                    "name"=> "淮北市",
                    "code"=> "340600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340601"
                        ),
                        array(
                            "name"=> "杜集区",
                            "code"=> "340602"
                        ),
                        array(
                            "name"=> "相山区",
                            "code"=> "340603"
                        ),
                        array(
                            "name"=> "烈山区",
                            "code"=> "340604"
                        ),
                        array(
                            "name"=> "濉溪县",
                            "code"=> "340621"
                        )
                    ]
                ),
                array(
                    "name"=> "铜陵市",
                    "code"=> "340700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340701"
                        ),
                        array(
                            "name"=> "铜官山区",
                            "code"=> "340702"
                        ),
                        array(
                            "name"=> "狮子山区",
                            "code"=> "340703"
                        ),
                        array(
                            "name"=> "郊区",
                            "code"=> "340711"
                        ),
                        array(
                            "name"=> "铜陵县",
                            "code"=> "340721"
                        )
                    ]
                ),
                array(
                    "name"=> "安庆市",
                    "code"=> "340800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "340801"
                        ),
                        array(
                            "name"=> "迎江区",
                            "code"=> "340802"
                        ),
                        array(
                            "name"=> "大观区",
                            "code"=> "340803"
                        ),
                        array(
                            "name"=> "宜秀区",
                            "code"=> "340811"
                        ),
                        array(
                            "name"=> "怀宁县",
                            "code"=> "340822"
                        ),
                        array(
                            "name"=> "枞阳县",
                            "code"=> "340823"
                        ),
                        array(
                            "name"=> "潜山县",
                            "code"=> "340824"
                        ),
                        array(
                            "name"=> "太湖县",
                            "code"=> "340825"
                        ),
                        array(
                            "name"=> "宿松县",
                            "code"=> "340826"
                        ),
                        array(
                            "name"=> "望江县",
                            "code"=> "340827"
                        ),
                        array(
                            "name"=> "岳西县",
                            "code"=> "340828"
                        ),
                        array(
                            "name"=> "桐城市",
                            "code"=> "340881"
                        )
                    ]
                ),
                array(
                    "name"=> "黄山市",
                    "code"=> "341000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341001"
                        ),
                        array(
                            "name"=> "屯溪区",
                            "code"=> "341002"
                        ),
                        array(
                            "name"=> "黄山区",
                            "code"=> "341003"
                        ),
                        array(
                            "name"=> "徽州区",
                            "code"=> "341004"
                        ),
                        array(
                            "name"=> "歙县",
                            "code"=> "341021"
                        ),
                        array(
                            "name"=> "休宁县",
                            "code"=> "341022"
                        ),
                        array(
                            "name"=> "黟县",
                            "code"=> "341023"
                        ),
                        array(
                            "name"=> "祁门县",
                            "code"=> "341024"
                        )
                    ]
                ),
                array(
                    "name"=> "滁州市",
                    "code"=> "341100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341101"
                        ),
                        array(
                            "name"=> "琅琊区",
                            "code"=> "341102"
                        ),
                        array(
                            "name"=> "南谯区",
                            "code"=> "341103"
                        ),
                        array(
                            "name"=> "来安县",
                            "code"=> "341122"
                        ),
                        array(
                            "name"=> "全椒县",
                            "code"=> "341124"
                        ),
                        array(
                            "name"=> "定远县",
                            "code"=> "341125"
                        ),
                        array(
                            "name"=> "凤阳县",
                            "code"=> "341126"
                        ),
                        array(
                            "name"=> "天长市",
                            "code"=> "341181"
                        ),
                        array(
                            "name"=> "明光市",
                            "code"=> "341182"
                        )
                    ]
                ),
                array(
                    "name"=> "阜阳市",
                    "code"=> "341200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341201"
                        ),
                        array(
                            "name"=> "颍州区",
                            "code"=> "341202"
                        ),
                        array(
                            "name"=> "颍东区",
                            "code"=> "341203"
                        ),
                        array(
                            "name"=> "颍泉区",
                            "code"=> "341204"
                        ),
                        array(
                            "name"=> "临泉县",
                            "code"=> "341221"
                        ),
                        array(
                            "name"=> "太和县",
                            "code"=> "341222"
                        ),
                        array(
                            "name"=> "阜南县",
                            "code"=> "341225"
                        ),
                        array(
                            "name"=> "颍上县",
                            "code"=> "341226"
                        ),
                        array(
                            "name"=> "界首市",
                            "code"=> "341282"
                        )
                    ]
                ),
                array(
                    "name"=> "宿州市",
                    "code"=> "341300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341301"
                        ),
                        array(
                            "name"=> "埇桥区",
                            "code"=> "341302"
                        ),
                        array(
                            "name"=> "砀山县",
                            "code"=> "341321"
                        ),
                        array(
                            "name"=> "萧县",
                            "code"=> "341322"
                        ),
                        array(
                            "name"=> "灵璧县",
                            "code"=> "341323"
                        ),
                        array(
                            "name"=> "泗县",
                            "code"=> "341324"
                        )
                    ]
                ),
                array(
                    "name"=> "六安市",
                    "code"=> "341500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341501"
                        ),
                        array(
                            "name"=> "金安区",
                            "code"=> "341502"
                        ),
                        array(
                            "name"=> "裕安区",
                            "code"=> "341503"
                        ),
                        array(
                            "name"=> "寿县",
                            "code"=> "341521"
                        ),
                        array(
                            "name"=> "霍邱县",
                            "code"=> "341522"
                        ),
                        array(
                            "name"=> "舒城县",
                            "code"=> "341523"
                        ),
                        array(
                            "name"=> "金寨县",
                            "code"=> "341524"
                        ),
                        array(
                            "name"=> "霍山县",
                            "code"=> "341525"
                        )
                    ]
                ),
                array(
                    "name"=> "亳州市",
                    "code"=> "341600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341601"
                        ),
                        array(
                            "name"=> "谯城区",
                            "code"=> "341602"
                        ),
                        array(
                            "name"=> "涡阳县",
                            "code"=> "341621"
                        ),
                        array(
                            "name"=> "蒙城县",
                            "code"=> "341622"
                        ),
                        array(
                            "name"=> "利辛县",
                            "code"=> "341623"
                        )
                    ]
                ),
                array(
                    "name"=> "池州市",
                    "code"=> "341700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341701"
                        ),
                        array(
                            "name"=> "贵池区",
                            "code"=> "341702"
                        ),
                        array(
                            "name"=> "东至县",
                            "code"=> "341721"
                        ),
                        array(
                            "name"=> "石台县",
                            "code"=> "341722"
                        ),
                        array(
                            "name"=> "青阳县",
                            "code"=> "341723"
                        )
                    ]
                ),
                array(
                    "name"=> "宣城市",
                    "code"=> "341800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "341801"
                        ),
                        array(
                            "name"=> "宣州区",
                            "code"=> "341802"
                        ),
                        array(
                            "name"=> "郎溪县",
                            "code"=> "341821"
                        ),
                        array(
                            "name"=> "广德县",
                            "code"=> "341822"
                        ),
                        array(
                            "name"=> "泾县",
                            "code"=> "341823"
                        ),
                        array(
                            "name"=> "绩溪县",
                            "code"=> "341824"
                        ),
                        array(
                            "name"=> "旌德县",
                            "code"=> "341825"
                        ),
                        array(
                            "name"=> "宁国市",
                            "code"=> "341881"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "福建省",
            "code"=> "350000",
            "sub"=> [
                array(
                    "name"=> "福州市",
                    "code"=> "350100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350101"
                        ),
                        array(
                            "name"=> "鼓楼区",
                            "code"=> "350102"
                        ),
                        array(
                            "name"=> "台江区",
                            "code"=> "350103"
                        ),
                        array(
                            "name"=> "仓山区",
                            "code"=> "350104"
                        ),
                        array(
                            "name"=> "马尾区",
                            "code"=> "350105"
                        ),
                        array(
                            "name"=> "晋安区",
                            "code"=> "350111"
                        ),
                        array(
                            "name"=> "闽侯县",
                            "code"=> "350121"
                        ),
                        array(
                            "name"=> "连江县",
                            "code"=> "350122"
                        ),
                        array(
                            "name"=> "罗源县",
                            "code"=> "350123"
                        ),
                        array(
                            "name"=> "闽清县",
                            "code"=> "350124"
                        ),
                        array(
                            "name"=> "永泰县",
                            "code"=> "350125"
                        ),
                        array(
                            "name"=> "平潭县",
                            "code"=> "350128"
                        ),
                        array(
                            "name"=> "福清市",
                            "code"=> "350181"
                        ),
                        array(
                            "name"=> "长乐市",
                            "code"=> "350182"
                        )
                    ]
                ),
                array(
                    "name"=> "厦门市",
                    "code"=> "350200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350201"
                        ),
                        array(
                            "name"=> "思明区",
                            "code"=> "350203"
                        ),
                        array(
                            "name"=> "海沧区",
                            "code"=> "350205"
                        ),
                        array(
                            "name"=> "湖里区",
                            "code"=> "350206"
                        ),
                        array(
                            "name"=> "集美区",
                            "code"=> "350211"
                        ),
                        array(
                            "name"=> "同安区",
                            "code"=> "350212"
                        ),
                        array(
                            "name"=> "翔安区",
                            "code"=> "350213"
                        )
                    ]
                ),
                array(
                    "name"=> "莆田市",
                    "code"=> "350300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350301"
                        ),
                        array(
                            "name"=> "城厢区",
                            "code"=> "350302"
                        ),
                        array(
                            "name"=> "涵江区",
                            "code"=> "350303"
                        ),
                        array(
                            "name"=> "荔城区",
                            "code"=> "350304"
                        ),
                        array(
                            "name"=> "秀屿区",
                            "code"=> "350305"
                        ),
                        array(
                            "name"=> "仙游县",
                            "code"=> "350322"
                        )
                    ]
                ),
                array(
                    "name"=> "三明市",
                    "code"=> "350400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350401"
                        ),
                        array(
                            "name"=> "梅列区",
                            "code"=> "350402"
                        ),
                        array(
                            "name"=> "三元区",
                            "code"=> "350403"
                        ),
                        array(
                            "name"=> "明溪县",
                            "code"=> "350421"
                        ),
                        array(
                            "name"=> "清流县",
                            "code"=> "350423"
                        ),
                        array(
                            "name"=> "宁化县",
                            "code"=> "350424"
                        ),
                        array(
                            "name"=> "大田县",
                            "code"=> "350425"
                        ),
                        array(
                            "name"=> "尤溪县",
                            "code"=> "350426"
                        ),
                        array(
                            "name"=> "沙县",
                            "code"=> "350427"
                        ),
                        array(
                            "name"=> "将乐县",
                            "code"=> "350428"
                        ),
                        array(
                            "name"=> "泰宁县",
                            "code"=> "350429"
                        ),
                        array(
                            "name"=> "建宁县",
                            "code"=> "350430"
                        ),
                        array(
                            "name"=> "永安市",
                            "code"=> "350481"
                        )
                    ]
                ),
                array(
                    "name"=> "泉州市",
                    "code"=> "350500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350501"
                        ),
                        array(
                            "name"=> "鲤城区",
                            "code"=> "350502"
                        ),
                        array(
                            "name"=> "丰泽区",
                            "code"=> "350503"
                        ),
                        array(
                            "name"=> "洛江区",
                            "code"=> "350504"
                        ),
                        array(
                            "name"=> "泉港区",
                            "code"=> "350505"
                        ),
                        array(
                            "name"=> "惠安县",
                            "code"=> "350521"
                        ),
                        array(
                            "name"=> "安溪县",
                            "code"=> "350524"
                        ),
                        array(
                            "name"=> "永春县",
                            "code"=> "350525"
                        ),
                        array(
                            "name"=> "德化县",
                            "code"=> "350526"
                        ),
                        array(
                            "name"=> "金门县",
                            "code"=> "350527"
                        ),
                        array(
                            "name"=> "石狮市",
                            "code"=> "350581"
                        ),
                        array(
                            "name"=> "晋江市",
                            "code"=> "350582"
                        ),
                        array(
                            "name"=> "南安市",
                            "code"=> "350583"
                        )
                    ]
                ),
                array(
                    "name"=> "漳州市",
                    "code"=> "350600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350601"
                        ),
                        array(
                            "name"=> "芗城区",
                            "code"=> "350602"
                        ),
                        array(
                            "name"=> "龙文区",
                            "code"=> "350603"
                        ),
                        array(
                            "name"=> "云霄县",
                            "code"=> "350622"
                        ),
                        array(
                            "name"=> "漳浦县",
                            "code"=> "350623"
                        ),
                        array(
                            "name"=> "诏安县",
                            "code"=> "350624"
                        ),
                        array(
                            "name"=> "长泰县",
                            "code"=> "350625"
                        ),
                        array(
                            "name"=> "东山县",
                            "code"=> "350626"
                        ),
                        array(
                            "name"=> "南靖县",
                            "code"=> "350627"
                        ),
                        array(
                            "name"=> "平和县",
                            "code"=> "350628"
                        ),
                        array(
                            "name"=> "华安县",
                            "code"=> "350629"
                        ),
                        array(
                            "name"=> "龙海市",
                            "code"=> "350681"
                        )
                    ]
                ),
                array(
                    "name"=> "南平市",
                    "code"=> "350700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350701"
                        ),
                        array(
                            "name"=> "延平区",
                            "code"=> "350702"
                        ),
                        array(
                            "name"=> "建阳区",
                            "code"=> "350703"
                        ),
                        array(
                            "name"=> "顺昌县",
                            "code"=> "350721"
                        ),
                        array(
                            "name"=> "浦城县",
                            "code"=> "350722"
                        ),
                        array(
                            "name"=> "光泽县",
                            "code"=> "350723"
                        ),
                        array(
                            "name"=> "松溪县",
                            "code"=> "350724"
                        ),
                        array(
                            "name"=> "政和县",
                            "code"=> "350725"
                        ),
                        array(
                            "name"=> "邵武市",
                            "code"=> "350781"
                        ),
                        array(
                            "name"=> "武夷山市",
                            "code"=> "350782"
                        ),
                        array(
                            "name"=> "建瓯市",
                            "code"=> "350783"
                        )
                    ]
                ),
                array(
                    "name"=> "龙岩市",
                    "code"=> "350800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350801"
                        ),
                        array(
                            "name"=> "新罗区",
                            "code"=> "350802"
                        ),
                        array(
                            "name"=> "永定区",
                            "code"=> "350803"
                        ),
                        array(
                            "name"=> "长汀县",
                            "code"=> "350821"
                        ),
                        array(
                            "name"=> "上杭县",
                            "code"=> "350823"
                        ),
                        array(
                            "name"=> "武平县",
                            "code"=> "350824"
                        ),
                        array(
                            "name"=> "连城县",
                            "code"=> "350825"
                        ),
                        array(
                            "name"=> "漳平市",
                            "code"=> "350881"
                        )
                    ]
                ),
                array(
                    "name"=> "宁德市",
                    "code"=> "350900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "350901"
                        ),
                        array(
                            "name"=> "蕉城区",
                            "code"=> "350902"
                        ),
                        array(
                            "name"=> "霞浦县",
                            "code"=> "350921"
                        ),
                        array(
                            "name"=> "古田县",
                            "code"=> "350922"
                        ),
                        array(
                            "name"=> "屏南县",
                            "code"=> "350923"
                        ),
                        array(
                            "name"=> "寿宁县",
                            "code"=> "350924"
                        ),
                        array(
                            "name"=> "周宁县",
                            "code"=> "350925"
                        ),
                        array(
                            "name"=> "柘荣县",
                            "code"=> "350926"
                        ),
                        array(
                            "name"=> "福安市",
                            "code"=> "350981"
                        ),
                        array(
                            "name"=> "福鼎市",
                            "code"=> "350982"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "江西省",
            "code"=> "360000",
            "sub"=> [
                array(
                    "name"=> "南昌市",
                    "code"=> "360100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360101"
                        ),
                        array(
                            "name"=> "东湖区",
                            "code"=> "360102"
                        ),
                        array(
                            "name"=> "西湖区",
                            "code"=> "360103"
                        ),
                        array(
                            "name"=> "青云谱区",
                            "code"=> "360104"
                        ),
                        array(
                            "name"=> "湾里区",
                            "code"=> "360105"
                        ),
                        array(
                            "name"=> "青山湖区",
                            "code"=> "360111"
                        ),
                        array(
                            "name"=> "南昌县",
                            "code"=> "360121"
                        ),
                        array(
                            "name"=> "新建县",
                            "code"=> "360122"
                        ),
                        array(
                            "name"=> "安义县",
                            "code"=> "360123"
                        ),
                        array(
                            "name"=> "进贤县",
                            "code"=> "360124"
                        )
                    ]
                ),
                array(
                    "name"=> "景德镇市",
                    "code"=> "360200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360201"
                        ),
                        array(
                            "name"=> "昌江区",
                            "code"=> "360202"
                        ),
                        array(
                            "name"=> "珠山区",
                            "code"=> "360203"
                        ),
                        array(
                            "name"=> "浮梁县",
                            "code"=> "360222"
                        ),
                        array(
                            "name"=> "乐平市",
                            "code"=> "360281"
                        )
                    ]
                ),
                array(
                    "name"=> "萍乡市",
                    "code"=> "360300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360301"
                        ),
                        array(
                            "name"=> "安源区",
                            "code"=> "360302"
                        ),
                        array(
                            "name"=> "湘东区",
                            "code"=> "360313"
                        ),
                        array(
                            "name"=> "莲花县",
                            "code"=> "360321"
                        ),
                        array(
                            "name"=> "上栗县",
                            "code"=> "360322"
                        ),
                        array(
                            "name"=> "芦溪县",
                            "code"=> "360323"
                        )
                    ]
                ),
                array(
                    "name"=> "九江市",
                    "code"=> "360400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360401"
                        ),
                        array(
                            "name"=> "庐山区",
                            "code"=> "360402"
                        ),
                        array(
                            "name"=> "浔阳区",
                            "code"=> "360403"
                        ),
                        array(
                            "name"=> "九江县",
                            "code"=> "360421"
                        ),
                        array(
                            "name"=> "武宁县",
                            "code"=> "360423"
                        ),
                        array(
                            "name"=> "修水县",
                            "code"=> "360424"
                        ),
                        array(
                            "name"=> "永修县",
                            "code"=> "360425"
                        ),
                        array(
                            "name"=> "德安县",
                            "code"=> "360426"
                        ),
                        array(
                            "name"=> "星子县",
                            "code"=> "360427"
                        ),
                        array(
                            "name"=> "都昌县",
                            "code"=> "360428"
                        ),
                        array(
                            "name"=> "湖口县",
                            "code"=> "360429"
                        ),
                        array(
                            "name"=> "彭泽县",
                            "code"=> "360430"
                        ),
                        array(
                            "name"=> "瑞昌市",
                            "code"=> "360481"
                        ),
                        array(
                            "name"=> "共青城市",
                            "code"=> "360482"
                        )
                    ]
                ),
                array(
                    "name"=> "新余市",
                    "code"=> "360500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360501"
                        ),
                        array(
                            "name"=> "渝水区",
                            "code"=> "360502"
                        ),
                        array(
                            "name"=> "分宜县",
                            "code"=> "360521"
                        )
                    ]
                ),
                array(
                    "name"=> "鹰潭市",
                    "code"=> "360600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360601"
                        ),
                        array(
                            "name"=> "月湖区",
                            "code"=> "360602"
                        ),
                        array(
                            "name"=> "余江县",
                            "code"=> "360622"
                        ),
                        array(
                            "name"=> "贵溪市",
                            "code"=> "360681"
                        )
                    ]
                ),
                array(
                    "name"=> "赣州市",
                    "code"=> "360700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360701"
                        ),
                        array(
                            "name"=> "章贡区",
                            "code"=> "360702"
                        ),
                        array(
                            "name"=> "南康区",
                            "code"=> "360703"
                        ),
                        array(
                            "name"=> "赣县",
                            "code"=> "360721"
                        ),
                        array(
                            "name"=> "信丰县",
                            "code"=> "360722"
                        ),
                        array(
                            "name"=> "大余县",
                            "code"=> "360723"
                        ),
                        array(
                            "name"=> "上犹县",
                            "code"=> "360724"
                        ),
                        array(
                            "name"=> "崇义县",
                            "code"=> "360725"
                        ),
                        array(
                            "name"=> "安远县",
                            "code"=> "360726"
                        ),
                        array(
                            "name"=> "龙南县",
                            "code"=> "360727"
                        ),
                        array(
                            "name"=> "定南县",
                            "code"=> "360728"
                        ),
                        array(
                            "name"=> "全南县",
                            "code"=> "360729"
                        ),
                        array(
                            "name"=> "宁都县",
                            "code"=> "360730"
                        ),
                        array(
                            "name"=> "于都县",
                            "code"=> "360731"
                        ),
                        array(
                            "name"=> "兴国县",
                            "code"=> "360732"
                        ),
                        array(
                            "name"=> "会昌县",
                            "code"=> "360733"
                        ),
                        array(
                            "name"=> "寻乌县",
                            "code"=> "360734"
                        ),
                        array(
                            "name"=> "石城县",
                            "code"=> "360735"
                        ),
                        array(
                            "name"=> "瑞金市",
                            "code"=> "360781"
                        )
                    ]
                ),
                array(
                    "name"=> "吉安市",
                    "code"=> "360800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360801"
                        ),
                        array(
                            "name"=> "吉州区",
                            "code"=> "360802"
                        ),
                        array(
                            "name"=> "青原区",
                            "code"=> "360803"
                        ),
                        array(
                            "name"=> "吉安县",
                            "code"=> "360821"
                        ),
                        array(
                            "name"=> "吉水县",
                            "code"=> "360822"
                        ),
                        array(
                            "name"=> "峡江县",
                            "code"=> "360823"
                        ),
                        array(
                            "name"=> "新干县",
                            "code"=> "360824"
                        ),
                        array(
                            "name"=> "永丰县",
                            "code"=> "360825"
                        ),
                        array(
                            "name"=> "泰和县",
                            "code"=> "360826"
                        ),
                        array(
                            "name"=> "遂川县",
                            "code"=> "360827"
                        ),
                        array(
                            "name"=> "万安县",
                            "code"=> "360828"
                        ),
                        array(
                            "name"=> "安福县",
                            "code"=> "360829"
                        ),
                        array(
                            "name"=> "永新县",
                            "code"=> "360830"
                        ),
                        array(
                            "name"=> "井冈山市",
                            "code"=> "360881"
                        )
                    ]
                ),
                array(
                    "name"=> "宜春市",
                    "code"=> "360900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "360901"
                        ),
                        array(
                            "name"=> "袁州区",
                            "code"=> "360902"
                        ),
                        array(
                            "name"=> "奉新县",
                            "code"=> "360921"
                        ),
                        array(
                            "name"=> "万载县",
                            "code"=> "360922"
                        ),
                        array(
                            "name"=> "上高县",
                            "code"=> "360923"
                        ),
                        array(
                            "name"=> "宜丰县",
                            "code"=> "360924"
                        ),
                        array(
                            "name"=> "靖安县",
                            "code"=> "360925"
                        ),
                        array(
                            "name"=> "铜鼓县",
                            "code"=> "360926"
                        ),
                        array(
                            "name"=> "丰城市",
                            "code"=> "360981"
                        ),
                        array(
                            "name"=> "樟树市",
                            "code"=> "360982"
                        ),
                        array(
                            "name"=> "高安市",
                            "code"=> "360983"
                        )
                    ]
                ),
                array(
                    "name"=> "抚州市",
                    "code"=> "361000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "361001"
                        ),
                        array(
                            "name"=> "临川区",
                            "code"=> "361002"
                        ),
                        array(
                            "name"=> "南城县",
                            "code"=> "361021"
                        ),
                        array(
                            "name"=> "黎川县",
                            "code"=> "361022"
                        ),
                        array(
                            "name"=> "南丰县",
                            "code"=> "361023"
                        ),
                        array(
                            "name"=> "崇仁县",
                            "code"=> "361024"
                        ),
                        array(
                            "name"=> "乐安县",
                            "code"=> "361025"
                        ),
                        array(
                            "name"=> "宜黄县",
                            "code"=> "361026"
                        ),
                        array(
                            "name"=> "金溪县",
                            "code"=> "361027"
                        ),
                        array(
                            "name"=> "资溪县",
                            "code"=> "361028"
                        ),
                        array(
                            "name"=> "东乡县",
                            "code"=> "361029"
                        ),
                        array(
                            "name"=> "广昌县",
                            "code"=> "361030"
                        )
                    ]
                ),
                array(
                    "name"=> "上饶市",
                    "code"=> "361100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "361101"
                        ),
                        array(
                            "name"=> "信州区",
                            "code"=> "361102"
                        ),
                        array(
                            "name"=> "上饶县",
                            "code"=> "361121"
                        ),
                        array(
                            "name"=> "广丰县",
                            "code"=> "361122"
                        ),
                        array(
                            "name"=> "玉山县",
                            "code"=> "361123"
                        ),
                        array(
                            "name"=> "铅山县",
                            "code"=> "361124"
                        ),
                        array(
                            "name"=> "横峰县",
                            "code"=> "361125"
                        ),
                        array(
                            "name"=> "弋阳县",
                            "code"=> "361126"
                        ),
                        array(
                            "name"=> "余干县",
                            "code"=> "361127"
                        ),
                        array(
                            "name"=> "鄱阳县",
                            "code"=> "361128"
                        ),
                        array(
                            "name"=> "万年县",
                            "code"=> "361129"
                        ),
                        array(
                            "name"=> "婺源县",
                            "code"=> "361130"
                        ),
                        array(
                            "name"=> "德兴市",
                            "code"=> "361181"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "山东省",
            "code"=> "370000",
            "sub"=> [
                array(
                    "name"=> "济南市",
                    "code"=> "370100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370101"
                        ),
                        array(
                            "name"=> "历下区",
                            "code"=> "370102"
                        ),
                        array(
                            "name"=> "市中区",
                            "code"=> "370103"
                        ),
                        array(
                            "name"=> "槐荫区",
                            "code"=> "370104"
                        ),
                        array(
                            "name"=> "天桥区",
                            "code"=> "370105"
                        ),
                        array(
                            "name"=> "历城区",
                            "code"=> "370112"
                        ),
                        array(
                            "name"=> "长清区",
                            "code"=> "370113"
                        ),
                        array(
                            "name"=> "平阴县",
                            "code"=> "370124"
                        ),
                        array(
                            "name"=> "济阳县",
                            "code"=> "370125"
                        ),
                        array(
                            "name"=> "商河县",
                            "code"=> "370126"
                        ),
                        array(
                            "name"=> "章丘市",
                            "code"=> "370181"
                        )
                    ]
                ),
                array(
                    "name"=> "青岛市",
                    "code"=> "370200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370201"
                        ),
                        array(
                            "name"=> "市南区",
                            "code"=> "370202"
                        ),
                        array(
                            "name"=> "市北区",
                            "code"=> "370203"
                        ),
                        array(
                            "name"=> "黄岛区",
                            "code"=> "370211"
                        ),
                        array(
                            "name"=> "崂山区",
                            "code"=> "370212"
                        ),
                        array(
                            "name"=> "李沧区",
                            "code"=> "370213"
                        ),
                        array(
                            "name"=> "城阳区",
                            "code"=> "370214"
                        ),
                        array(
                            "name"=> "胶州市",
                            "code"=> "370281"
                        ),
                        array(
                            "name"=> "即墨市",
                            "code"=> "370282"
                        ),
                        array(
                            "name"=> "平度市",
                            "code"=> "370283"
                        ),
                        array(
                            "name"=> "莱西市",
                            "code"=> "370285"
                        )
                    ]
                ),
                array(
                    "name"=> "淄博市",
                    "code"=> "370300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370301"
                        ),
                        array(
                            "name"=> "淄川区",
                            "code"=> "370302"
                        ),
                        array(
                            "name"=> "张店区",
                            "code"=> "370303"
                        ),
                        array(
                            "name"=> "博山区",
                            "code"=> "370304"
                        ),
                        array(
                            "name"=> "临淄区",
                            "code"=> "370305"
                        ),
                        array(
                            "name"=> "周村区",
                            "code"=> "370306"
                        ),
                        array(
                            "name"=> "桓台县",
                            "code"=> "370321"
                        ),
                        array(
                            "name"=> "高青县",
                            "code"=> "370322"
                        ),
                        array(
                            "name"=> "沂源县",
                            "code"=> "370323"
                        )
                    ]
                ),
                array(
                    "name"=> "枣庄市",
                    "code"=> "370400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370401"
                        ),
                        array(
                            "name"=> "市中区",
                            "code"=> "370402"
                        ),
                        array(
                            "name"=> "薛城区",
                            "code"=> "370403"
                        ),
                        array(
                            "name"=> "峄城区",
                            "code"=> "370404"
                        ),
                        array(
                            "name"=> "台儿庄区",
                            "code"=> "370405"
                        ),
                        array(
                            "name"=> "山亭区",
                            "code"=> "370406"
                        ),
                        array(
                            "name"=> "滕州市",
                            "code"=> "370481"
                        )
                    ]
                ),
                array(
                    "name"=> "东营市",
                    "code"=> "370500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370501"
                        ),
                        array(
                            "name"=> "东营区",
                            "code"=> "370502"
                        ),
                        array(
                            "name"=> "河口区",
                            "code"=> "370503"
                        ),
                        array(
                            "name"=> "垦利县",
                            "code"=> "370521"
                        ),
                        array(
                            "name"=> "利津县",
                            "code"=> "370522"
                        ),
                        array(
                            "name"=> "广饶县",
                            "code"=> "370523"
                        )
                    ]
                ),
                array(
                    "name"=> "烟台市",
                    "code"=> "370600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370601"
                        ),
                        array(
                            "name"=> "芝罘区",
                            "code"=> "370602"
                        ),
                        array(
                            "name"=> "福山区",
                            "code"=> "370611"
                        ),
                        array(
                            "name"=> "牟平区",
                            "code"=> "370612"
                        ),
                        array(
                            "name"=> "莱山区",
                            "code"=> "370613"
                        ),
                        array(
                            "name"=> "长岛县",
                            "code"=> "370634"
                        ),
                        array(
                            "name"=> "龙口市",
                            "code"=> "370681"
                        ),
                        array(
                            "name"=> "莱阳市",
                            "code"=> "370682"
                        ),
                        array(
                            "name"=> "莱州市",
                            "code"=> "370683"
                        ),
                        array(
                            "name"=> "蓬莱市",
                            "code"=> "370684"
                        ),
                        array(
                            "name"=> "招远市",
                            "code"=> "370685"
                        ),
                        array(
                            "name"=> "栖霞市",
                            "code"=> "370686"
                        ),
                        array(
                            "name"=> "海阳市",
                            "code"=> "370687"
                        )
                    ]
                ),
                array(
                    "name"=> "潍坊市",
                    "code"=> "370700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370701"
                        ),
                        array(
                            "name"=> "潍城区",
                            "code"=> "370702"
                        ),
                        array(
                            "name"=> "寒亭区",
                            "code"=> "370703"
                        ),
                        array(
                            "name"=> "坊子区",
                            "code"=> "370704"
                        ),
                        array(
                            "name"=> "奎文区",
                            "code"=> "370705"
                        ),
                        array(
                            "name"=> "临朐县",
                            "code"=> "370724"
                        ),
                        array(
                            "name"=> "昌乐县",
                            "code"=> "370725"
                        ),
                        array(
                            "name"=> "青州市",
                            "code"=> "370781"
                        ),
                        array(
                            "name"=> "诸城市",
                            "code"=> "370782"
                        ),
                        array(
                            "name"=> "寿光市",
                            "code"=> "370783"
                        ),
                        array(
                            "name"=> "安丘市",
                            "code"=> "370784"
                        ),
                        array(
                            "name"=> "高密市",
                            "code"=> "370785"
                        ),
                        array(
                            "name"=> "昌邑市",
                            "code"=> "370786"
                        )
                    ]
                ),
                array(
                    "name"=> "济宁市",
                    "code"=> "370800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370801"
                        ),
                        array(
                            "name"=> "任城区",
                            "code"=> "370811"
                        ),
                        array(
                            "name"=> "兖州区",
                            "code"=> "370812"
                        ),
                        array(
                            "name"=> "微山县",
                            "code"=> "370826"
                        ),
                        array(
                            "name"=> "鱼台县",
                            "code"=> "370827"
                        ),
                        array(
                            "name"=> "金乡县",
                            "code"=> "370828"
                        ),
                        array(
                            "name"=> "嘉祥县",
                            "code"=> "370829"
                        ),
                        array(
                            "name"=> "汶上县",
                            "code"=> "370830"
                        ),
                        array(
                            "name"=> "泗水县",
                            "code"=> "370831"
                        ),
                        array(
                            "name"=> "梁山县",
                            "code"=> "370832"
                        ),
                        array(
                            "name"=> "曲阜市",
                            "code"=> "370881"
                        ),
                        array(
                            "name"=> "邹城市",
                            "code"=> "370883"
                        )
                    ]
                ),
                array(
                    "name"=> "泰安市",
                    "code"=> "370900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "370901"
                        ),
                        array(
                            "name"=> "泰山区",
                            "code"=> "370902"
                        ),
                        array(
                            "name"=> "岱岳区",
                            "code"=> "370911"
                        ),
                        array(
                            "name"=> "宁阳县",
                            "code"=> "370921"
                        ),
                        array(
                            "name"=> "东平县",
                            "code"=> "370923"
                        ),
                        array(
                            "name"=> "新泰市",
                            "code"=> "370982"
                        ),
                        array(
                            "name"=> "肥城市",
                            "code"=> "370983"
                        )
                    ]
                ),
                array(
                    "name"=> "威海市",
                    "code"=> "371000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371001"
                        ),
                        array(
                            "name"=> "环翠区",
                            "code"=> "371002"
                        ),
                        array(
                            "name"=> "文登市",
                            "code"=> "371081"
                        ),
                        array(
                            "name"=> "荣成市",
                            "code"=> "371082"
                        ),
                        array(
                            "name"=> "乳山市",
                            "code"=> "371083"
                        )
                    ]
                ),
                array(
                    "name"=> "日照市",
                    "code"=> "371100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371101"
                        ),
                        array(
                            "name"=> "东港区",
                            "code"=> "371102"
                        ),
                        array(
                            "name"=> "岚山区",
                            "code"=> "371103"
                        ),
                        array(
                            "name"=> "五莲县",
                            "code"=> "371121"
                        ),
                        array(
                            "name"=> "莒县",
                            "code"=> "371122"
                        )
                    ]
                ),
                array(
                    "name"=> "莱芜市",
                    "code"=> "371200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371201"
                        ),
                        array(
                            "name"=> "莱城区",
                            "code"=> "371202"
                        ),
                        array(
                            "name"=> "钢城区",
                            "code"=> "371203"
                        )
                    ]
                ),
                array(
                    "name"=> "临沂市",
                    "code"=> "371300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371301"
                        ),
                        array(
                            "name"=> "兰山区",
                            "code"=> "371302"
                        ),
                        array(
                            "name"=> "罗庄区",
                            "code"=> "371311"
                        ),
                        array(
                            "name"=> "河东区",
                            "code"=> "371312"
                        ),
                        array(
                            "name"=> "沂南县",
                            "code"=> "371321"
                        ),
                        array(
                            "name"=> "郯城县",
                            "code"=> "371322"
                        ),
                        array(
                            "name"=> "沂水县",
                            "code"=> "371323"
                        ),
                        array(
                            "name"=> "兰陵县",
                            "code"=> "371324"
                        ),
                        array(
                            "name"=> "费县",
                            "code"=> "371325"
                        ),
                        array(
                            "name"=> "平邑县",
                            "code"=> "371326"
                        ),
                        array(
                            "name"=> "莒南县",
                            "code"=> "371327"
                        ),
                        array(
                            "name"=> "蒙阴县",
                            "code"=> "371328"
                        ),
                        array(
                            "name"=> "临沭县",
                            "code"=> "371329"
                        )
                    ]
                ),
                array(
                    "name"=> "德州市",
                    "code"=> "371400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371401"
                        ),
                        array(
                            "name"=> "德城区",
                            "code"=> "371402"
                        ),
                        array(
                            "name"=> "陵城区",
                            "code"=> "371403"
                        ),
                        array(
                            "name"=> "宁津县",
                            "code"=> "371422"
                        ),
                        array(
                            "name"=> "庆云县",
                            "code"=> "371423"
                        ),
                        array(
                            "name"=> "临邑县",
                            "code"=> "371424"
                        ),
                        array(
                            "name"=> "齐河县",
                            "code"=> "371425"
                        ),
                        array(
                            "name"=> "平原县",
                            "code"=> "371426"
                        ),
                        array(
                            "name"=> "夏津县",
                            "code"=> "371427"
                        ),
                        array(
                            "name"=> "武城县",
                            "code"=> "371428"
                        ),
                        array(
                            "name"=> "乐陵市",
                            "code"=> "371481"
                        ),
                        array(
                            "name"=> "禹城市",
                            "code"=> "371482"
                        )
                    ]
                ),
                array(
                    "name"=> "聊城市",
                    "code"=> "371500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371501"
                        ),
                        array(
                            "name"=> "东昌府区",
                            "code"=> "371502"
                        ),
                        array(
                            "name"=> "阳谷县",
                            "code"=> "371521"
                        ),
                        array(
                            "name"=> "莘县",
                            "code"=> "371522"
                        ),
                        array(
                            "name"=> "茌平县",
                            "code"=> "371523"
                        ),
                        array(
                            "name"=> "东阿县",
                            "code"=> "371524"
                        ),
                        array(
                            "name"=> "冠县",
                            "code"=> "371525"
                        ),
                        array(
                            "name"=> "高唐县",
                            "code"=> "371526"
                        ),
                        array(
                            "name"=> "临清市",
                            "code"=> "371581"
                        )
                    ]
                ),
                array(
                    "name"=> "滨州市",
                    "code"=> "371600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371601"
                        ),
                        array(
                            "name"=> "滨城区",
                            "code"=> "371602"
                        ),
                        array(
                            "name"=> "沾化区",
                            "code"=> "371603"
                        ),
                        array(
                            "name"=> "惠民县",
                            "code"=> "371621"
                        ),
                        array(
                            "name"=> "阳信县",
                            "code"=> "371622"
                        ),
                        array(
                            "name"=> "无棣县",
                            "code"=> "371623"
                        ),
                        array(
                            "name"=> "博兴县",
                            "code"=> "371625"
                        ),
                        array(
                            "name"=> "邹平县",
                            "code"=> "371626"
                        )
                    ]
                ),
                array(
                    "name"=> "菏泽市",
                    "code"=> "371700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "371701"
                        ),
                        array(
                            "name"=> "牡丹区",
                            "code"=> "371702"
                        ),
                        array(
                            "name"=> "曹县",
                            "code"=> "371721"
                        ),
                        array(
                            "name"=> "单县",
                            "code"=> "371722"
                        ),
                        array(
                            "name"=> "成武县",
                            "code"=> "371723"
                        ),
                        array(
                            "name"=> "巨野县",
                            "code"=> "371724"
                        ),
                        array(
                            "name"=> "郓城县",
                            "code"=> "371725"
                        ),
                        array(
                            "name"=> "鄄城县",
                            "code"=> "371726"
                        ),
                        array(
                            "name"=> "定陶县",
                            "code"=> "371727"
                        ),
                        array(
                            "name"=> "东明县",
                            "code"=> "371728"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "河南省",
            "code"=> "410000",
            "sub"=> [
                array(
                    "name"=> "郑州市",
                    "code"=> "410100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410101"
                        ),
                        array(
                            "name"=> "中原区",
                            "code"=> "410102"
                        ),
                        array(
                            "name"=> "二七区",
                            "code"=> "410103"
                        ),
                        array(
                            "name"=> "管城回族区",
                            "code"=> "410104"
                        ),
                        array(
                            "name"=> "金水区",
                            "code"=> "410105"
                        ),
                        array(
                            "name"=> "上街区",
                            "code"=> "410106"
                        ),
                        array(
                            "name"=> "惠济区",
                            "code"=> "410108"
                        ),
                        array(
                            "name"=> "中牟县",
                            "code"=> "410122"
                        ),
                        array(
                            "name"=> "巩义市",
                            "code"=> "410181"
                        ),
                        array(
                            "name"=> "荥阳市",
                            "code"=> "410182"
                        ),
                        array(
                            "name"=> "新密市",
                            "code"=> "410183"
                        ),
                        array(
                            "name"=> "新郑市",
                            "code"=> "410184"
                        ),
                        array(
                            "name"=> "登封市",
                            "code"=> "410185"
                        )
                    ]
                ),
                array(
                    "name"=> "开封市",
                    "code"=> "410200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410201"
                        ),
                        array(
                            "name"=> "龙亭区",
                            "code"=> "410202"
                        ),
                        array(
                            "name"=> "顺河回族区",
                            "code"=> "410203"
                        ),
                        array(
                            "name"=> "鼓楼区",
                            "code"=> "410204"
                        ),
                        array(
                            "name"=> "禹王台区",
                            "code"=> "410205"
                        ),
                        array(
                            "name"=> "祥符区",
                            "code"=> "410212"
                        ),
                        array(
                            "name"=> "杞县",
                            "code"=> "410221"
                        ),
                        array(
                            "name"=> "通许县",
                            "code"=> "410222"
                        ),
                        array(
                            "name"=> "尉氏县",
                            "code"=> "410223"
                        ),
                        array(
                            "name"=> "兰考县",
                            "code"=> "410225"
                        )
                    ]
                ),
                array(
                    "name"=> "洛阳市",
                    "code"=> "410300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410301"
                        ),
                        array(
                            "name"=> "老城区",
                            "code"=> "410302"
                        ),
                        array(
                            "name"=> "西工区",
                            "code"=> "410303"
                        ),
                        array(
                            "name"=> "瀍河回族区",
                            "code"=> "410304"
                        ),
                        array(
                            "name"=> "涧西区",
                            "code"=> "410305"
                        ),
                        array(
                            "name"=> "吉利区",
                            "code"=> "410306"
                        ),
                        array(
                            "name"=> "洛龙区",
                            "code"=> "410311"
                        ),
                        array(
                            "name"=> "孟津县",
                            "code"=> "410322"
                        ),
                        array(
                            "name"=> "新安县",
                            "code"=> "410323"
                        ),
                        array(
                            "name"=> "栾川县",
                            "code"=> "410324"
                        ),
                        array(
                            "name"=> "嵩县",
                            "code"=> "410325"
                        ),
                        array(
                            "name"=> "汝阳县",
                            "code"=> "410326"
                        ),
                        array(
                            "name"=> "宜阳县",
                            "code"=> "410327"
                        ),
                        array(
                            "name"=> "洛宁县",
                            "code"=> "410328"
                        ),
                        array(
                            "name"=> "伊川县",
                            "code"=> "410329"
                        ),
                        array(
                            "name"=> "偃师市",
                            "code"=> "410381"
                        )
                    ]
                ),
                array(
                    "name"=> "平顶山市",
                    "code"=> "410400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410401"
                        ),
                        array(
                            "name"=> "新华区",
                            "code"=> "410402"
                        ),
                        array(
                            "name"=> "卫东区",
                            "code"=> "410403"
                        ),
                        array(
                            "name"=> "石龙区",
                            "code"=> "410404"
                        ),
                        array(
                            "name"=> "湛河区",
                            "code"=> "410411"
                        ),
                        array(
                            "name"=> "宝丰县",
                            "code"=> "410421"
                        ),
                        array(
                            "name"=> "叶县",
                            "code"=> "410422"
                        ),
                        array(
                            "name"=> "鲁山县",
                            "code"=> "410423"
                        ),
                        array(
                            "name"=> "郏县",
                            "code"=> "410425"
                        ),
                        array(
                            "name"=> "舞钢市",
                            "code"=> "410481"
                        ),
                        array(
                            "name"=> "汝州市",
                            "code"=> "410482"
                        )
                    ]
                ),
                array(
                    "name"=> "安阳市",
                    "code"=> "410500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410501"
                        ),
                        array(
                            "name"=> "文峰区",
                            "code"=> "410502"
                        ),
                        array(
                            "name"=> "北关区",
                            "code"=> "410503"
                        ),
                        array(
                            "name"=> "殷都区",
                            "code"=> "410505"
                        ),
                        array(
                            "name"=> "龙安区",
                            "code"=> "410506"
                        ),
                        array(
                            "name"=> "安阳县",
                            "code"=> "410522"
                        ),
                        array(
                            "name"=> "汤阴县",
                            "code"=> "410523"
                        ),
                        array(
                            "name"=> "滑县",
                            "code"=> "410526"
                        ),
                        array(
                            "name"=> "内黄县",
                            "code"=> "410527"
                        ),
                        array(
                            "name"=> "林州市",
                            "code"=> "410581"
                        )
                    ]
                ),
                array(
                    "name"=> "鹤壁市",
                    "code"=> "410600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410601"
                        ),
                        array(
                            "name"=> "鹤山区",
                            "code"=> "410602"
                        ),
                        array(
                            "name"=> "山城区",
                            "code"=> "410603"
                        ),
                        array(
                            "name"=> "淇滨区",
                            "code"=> "410611"
                        ),
                        array(
                            "name"=> "浚县",
                            "code"=> "410621"
                        ),
                        array(
                            "name"=> "淇县",
                            "code"=> "410622"
                        )
                    ]
                ),
                array(
                    "name"=> "新乡市",
                    "code"=> "410700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410701"
                        ),
                        array(
                            "name"=> "红旗区",
                            "code"=> "410702"
                        ),
                        array(
                            "name"=> "卫滨区",
                            "code"=> "410703"
                        ),
                        array(
                            "name"=> "凤泉区",
                            "code"=> "410704"
                        ),
                        array(
                            "name"=> "牧野区",
                            "code"=> "410711"
                        ),
                        array(
                            "name"=> "新乡县",
                            "code"=> "410721"
                        ),
                        array(
                            "name"=> "获嘉县",
                            "code"=> "410724"
                        ),
                        array(
                            "name"=> "原阳县",
                            "code"=> "410725"
                        ),
                        array(
                            "name"=> "延津县",
                            "code"=> "410726"
                        ),
                        array(
                            "name"=> "封丘县",
                            "code"=> "410727"
                        ),
                        array(
                            "name"=> "长垣县",
                            "code"=> "410728"
                        ),
                        array(
                            "name"=> "卫辉市",
                            "code"=> "410781"
                        ),
                        array(
                            "name"=> "辉县市",
                            "code"=> "410782"
                        )
                    ]
                ),
                array(
                    "name"=> "焦作市",
                    "code"=> "410800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410801"
                        ),
                        array(
                            "name"=> "解放区",
                            "code"=> "410802"
                        ),
                        array(
                            "name"=> "中站区",
                            "code"=> "410803"
                        ),
                        array(
                            "name"=> "马村区",
                            "code"=> "410804"
                        ),
                        array(
                            "name"=> "山阳区",
                            "code"=> "410811"
                        ),
                        array(
                            "name"=> "修武县",
                            "code"=> "410821"
                        ),
                        array(
                            "name"=> "博爱县",
                            "code"=> "410822"
                        ),
                        array(
                            "name"=> "武陟县",
                            "code"=> "410823"
                        ),
                        array(
                            "name"=> "温县",
                            "code"=> "410825"
                        ),
                        array(
                            "name"=> "沁阳市",
                            "code"=> "410882"
                        ),
                        array(
                            "name"=> "孟州市",
                            "code"=> "410883"
                        )
                    ]
                ),
                array(
                    "name"=> "濮阳市",
                    "code"=> "410900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "410901"
                        ),
                        array(
                            "name"=> "华龙区",
                            "code"=> "410902"
                        ),
                        array(
                            "name"=> "清丰县",
                            "code"=> "410922"
                        ),
                        array(
                            "name"=> "南乐县",
                            "code"=> "410923"
                        ),
                        array(
                            "name"=> "范县",
                            "code"=> "410926"
                        ),
                        array(
                            "name"=> "台前县",
                            "code"=> "410927"
                        ),
                        array(
                            "name"=> "濮阳县",
                            "code"=> "410928"
                        )
                    ]
                ),
                array(
                    "name"=> "许昌市",
                    "code"=> "411000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411001"
                        ),
                        array(
                            "name"=> "魏都区",
                            "code"=> "411002"
                        ),
                        array(
                            "name"=> "许昌县",
                            "code"=> "411023"
                        ),
                        array(
                            "name"=> "鄢陵县",
                            "code"=> "411024"
                        ),
                        array(
                            "name"=> "襄城县",
                            "code"=> "411025"
                        ),
                        array(
                            "name"=> "禹州市",
                            "code"=> "411081"
                        ),
                        array(
                            "name"=> "长葛市",
                            "code"=> "411082"
                        )
                    ]
                ),
                array(
                    "name"=> "漯河市",
                    "code"=> "411100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411101"
                        ),
                        array(
                            "name"=> "源汇区",
                            "code"=> "411102"
                        ),
                        array(
                            "name"=> "郾城区",
                            "code"=> "411103"
                        ),
                        array(
                            "name"=> "召陵区",
                            "code"=> "411104"
                        ),
                        array(
                            "name"=> "舞阳县",
                            "code"=> "411121"
                        ),
                        array(
                            "name"=> "临颍县",
                            "code"=> "411122"
                        )
                    ]
                ),
                array(
                    "name"=> "三门峡市",
                    "code"=> "411200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411201"
                        ),
                        array(
                            "name"=> "湖滨区",
                            "code"=> "411202"
                        ),
                        array(
                            "name"=> "渑池县",
                            "code"=> "411221"
                        ),
                        array(
                            "name"=> "陕县",
                            "code"=> "411222"
                        ),
                        array(
                            "name"=> "卢氏县",
                            "code"=> "411224"
                        ),
                        array(
                            "name"=> "义马市",
                            "code"=> "411281"
                        ),
                        array(
                            "name"=> "灵宝市",
                            "code"=> "411282"
                        )
                    ]
                ),
                array(
                    "name"=> "南阳市",
                    "code"=> "411300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411301"
                        ),
                        array(
                            "name"=> "宛城区",
                            "code"=> "411302"
                        ),
                        array(
                            "name"=> "卧龙区",
                            "code"=> "411303"
                        ),
                        array(
                            "name"=> "南召县",
                            "code"=> "411321"
                        ),
                        array(
                            "name"=> "方城县",
                            "code"=> "411322"
                        ),
                        array(
                            "name"=> "西峡县",
                            "code"=> "411323"
                        ),
                        array(
                            "name"=> "镇平县",
                            "code"=> "411324"
                        ),
                        array(
                            "name"=> "内乡县",
                            "code"=> "411325"
                        ),
                        array(
                            "name"=> "淅川县",
                            "code"=> "411326"
                        ),
                        array(
                            "name"=> "社旗县",
                            "code"=> "411327"
                        ),
                        array(
                            "name"=> "唐河县",
                            "code"=> "411328"
                        ),
                        array(
                            "name"=> "新野县",
                            "code"=> "411329"
                        ),
                        array(
                            "name"=> "桐柏县",
                            "code"=> "411330"
                        ),
                        array(
                            "name"=> "邓州市",
                            "code"=> "411381"
                        )
                    ]
                ),
                array(
                    "name"=> "商丘市",
                    "code"=> "411400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411401"
                        ),
                        array(
                            "name"=> "梁园区",
                            "code"=> "411402"
                        ),
                        array(
                            "name"=> "睢阳区",
                            "code"=> "411403"
                        ),
                        array(
                            "name"=> "民权县",
                            "code"=> "411421"
                        ),
                        array(
                            "name"=> "睢县",
                            "code"=> "411422"
                        ),
                        array(
                            "name"=> "宁陵县",
                            "code"=> "411423"
                        ),
                        array(
                            "name"=> "柘城县",
                            "code"=> "411424"
                        ),
                        array(
                            "name"=> "虞城县",
                            "code"=> "411425"
                        ),
                        array(
                            "name"=> "夏邑县",
                            "code"=> "411426"
                        ),
                        array(
                            "name"=> "永城市",
                            "code"=> "411481"
                        )
                    ]
                ),
                array(
                    "name"=> "信阳市",
                    "code"=> "411500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411501"
                        ),
                        array(
                            "name"=> "浉河区",
                            "code"=> "411502"
                        ),
                        array(
                            "name"=> "平桥区",
                            "code"=> "411503"
                        ),
                        array(
                            "name"=> "罗山县",
                            "code"=> "411521"
                        ),
                        array(
                            "name"=> "光山县",
                            "code"=> "411522"
                        ),
                        array(
                            "name"=> "新县",
                            "code"=> "411523"
                        ),
                        array(
                            "name"=> "商城县",
                            "code"=> "411524"
                        ),
                        array(
                            "name"=> "固始县",
                            "code"=> "411525"
                        ),
                        array(
                            "name"=> "潢川县",
                            "code"=> "411526"
                        ),
                        array(
                            "name"=> "淮滨县",
                            "code"=> "411527"
                        ),
                        array(
                            "name"=> "息县",
                            "code"=> "411528"
                        )
                    ]
                ),
                array(
                    "name"=> "周口市",
                    "code"=> "411600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411601"
                        ),
                        array(
                            "name"=> "川汇区",
                            "code"=> "411602"
                        ),
                        array(
                            "name"=> "扶沟县",
                            "code"=> "411621"
                        ),
                        array(
                            "name"=> "西华县",
                            "code"=> "411622"
                        ),
                        array(
                            "name"=> "商水县",
                            "code"=> "411623"
                        ),
                        array(
                            "name"=> "沈丘县",
                            "code"=> "411624"
                        ),
                        array(
                            "name"=> "郸城县",
                            "code"=> "411625"
                        ),
                        array(
                            "name"=> "淮阳县",
                            "code"=> "411626"
                        ),
                        array(
                            "name"=> "太康县",
                            "code"=> "411627"
                        ),
                        array(
                            "name"=> "鹿邑县",
                            "code"=> "411628"
                        ),
                        array(
                            "name"=> "项城市",
                            "code"=> "411681"
                        )
                    ]
                ),
                array(
                    "name"=> "驻马店市",
                    "code"=> "411700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "411701"
                        ),
                        array(
                            "name"=> "驿城区",
                            "code"=> "411702"
                        ),
                        array(
                            "name"=> "西平县",
                            "code"=> "411721"
                        ),
                        array(
                            "name"=> "上蔡县",
                            "code"=> "411722"
                        ),
                        array(
                            "name"=> "平舆县",
                            "code"=> "411723"
                        ),
                        array(
                            "name"=> "正阳县",
                            "code"=> "411724"
                        ),
                        array(
                            "name"=> "确山县",
                            "code"=> "411725"
                        ),
                        array(
                            "name"=> "泌阳县",
                            "code"=> "411726"
                        ),
                        array(
                            "name"=> "汝南县",
                            "code"=> "411727"
                        ),
                        array(
                            "name"=> "遂平县",
                            "code"=> "411728"
                        ),
                        array(
                            "name"=> "新蔡县",
                            "code"=> "411729"
                        )
                    ]
                ),
                array(
                    "name"=> "济源市",
                    "code"=> "419001"
                )
            ]
        ),
        array(
            "name"=> "湖北省",
            "code"=> "420000",
            "sub"=> [
                array(
                    "name"=> "武汉市",
                    "code"=> "420100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420101"
                        ),
                        array(
                            "name"=> "江岸区",
                            "code"=> "420102"
                        ),
                        array(
                            "name"=> "江汉区",
                            "code"=> "420103"
                        ),
                        array(
                            "name"=> "硚口区",
                            "code"=> "420104"
                        ),
                        array(
                            "name"=> "汉阳区",
                            "code"=> "420105"
                        ),
                        array(
                            "name"=> "武昌区",
                            "code"=> "420106"
                        ),
                        array(
                            "name"=> "青山区",
                            "code"=> "420107"
                        ),
                        array(
                            "name"=> "洪山区",
                            "code"=> "420111"
                        ),
                        array(
                            "name"=> "东西湖区",
                            "code"=> "420112"
                        ),
                        array(
                            "name"=> "汉南区",
                            "code"=> "420113"
                        ),
                        array(
                            "name"=> "蔡甸区",
                            "code"=> "420114"
                        ),
                        array(
                            "name"=> "江夏区",
                            "code"=> "420115"
                        ),
                        array(
                            "name"=> "黄陂区",
                            "code"=> "420116"
                        ),
                        array(
                            "name"=> "新洲区",
                            "code"=> "420117"
                        )
                    ]
                ),
                array(
                    "name"=> "黄石市",
                    "code"=> "420200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420201"
                        ),
                        array(
                            "name"=> "黄石港区",
                            "code"=> "420202"
                        ),
                        array(
                            "name"=> "西塞山区",
                            "code"=> "420203"
                        ),
                        array(
                            "name"=> "下陆区",
                            "code"=> "420204"
                        ),
                        array(
                            "name"=> "铁山区",
                            "code"=> "420205"
                        ),
                        array(
                            "name"=> "阳新县",
                            "code"=> "420222"
                        ),
                        array(
                            "name"=> "大冶市",
                            "code"=> "420281"
                        )
                    ]
                ),
                array(
                    "name"=> "十堰市",
                    "code"=> "420300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420301"
                        ),
                        array(
                            "name"=> "茅箭区",
                            "code"=> "420302"
                        ),
                        array(
                            "name"=> "张湾区",
                            "code"=> "420303"
                        ),
                        array(
                            "name"=> "郧阳区",
                            "code"=> "420304"
                        ),
                        array(
                            "name"=> "郧西县",
                            "code"=> "420322"
                        ),
                        array(
                            "name"=> "竹山县",
                            "code"=> "420323"
                        ),
                        array(
                            "name"=> "竹溪县",
                            "code"=> "420324"
                        ),
                        array(
                            "name"=> "房县",
                            "code"=> "420325"
                        ),
                        array(
                            "name"=> "丹江口市",
                            "code"=> "420381"
                        )
                    ]
                ),
                array(
                    "name"=> "宜昌市",
                    "code"=> "420500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420501"
                        ),
                        array(
                            "name"=> "西陵区",
                            "code"=> "420502"
                        ),
                        array(
                            "name"=> "伍家岗区",
                            "code"=> "420503"
                        ),
                        array(
                            "name"=> "点军区",
                            "code"=> "420504"
                        ),
                        array(
                            "name"=> "猇亭区",
                            "code"=> "420505"
                        ),
                        array(
                            "name"=> "夷陵区",
                            "code"=> "420506"
                        ),
                        array(
                            "name"=> "远安县",
                            "code"=> "420525"
                        ),
                        array(
                            "name"=> "兴山县",
                            "code"=> "420526"
                        ),
                        array(
                            "name"=> "秭归县",
                            "code"=> "420527"
                        ),
                        array(
                            "name"=> "长阳土家族自治县",
                            "code"=> "420528"
                        ),
                        array(
                            "name"=> "五峰土家族自治县",
                            "code"=> "420529"
                        ),
                        array(
                            "name"=> "宜都市",
                            "code"=> "420581"
                        ),
                        array(
                            "name"=> "当阳市",
                            "code"=> "420582"
                        ),
                        array(
                            "name"=> "枝江市",
                            "code"=> "420583"
                        )
                    ]
                ),
                array(
                    "name"=> "襄阳市",
                    "code"=> "420600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420601"
                        ),
                        array(
                            "name"=> "襄城区",
                            "code"=> "420602"
                        ),
                        array(
                            "name"=> "樊城区",
                            "code"=> "420606"
                        ),
                        array(
                            "name"=> "襄州区",
                            "code"=> "420607"
                        ),
                        array(
                            "name"=> "南漳县",
                            "code"=> "420624"
                        ),
                        array(
                            "name"=> "谷城县",
                            "code"=> "420625"
                        ),
                        array(
                            "name"=> "保康县",
                            "code"=> "420626"
                        ),
                        array(
                            "name"=> "老河口市",
                            "code"=> "420682"
                        ),
                        array(
                            "name"=> "枣阳市",
                            "code"=> "420683"
                        ),
                        array(
                            "name"=> "宜城市",
                            "code"=> "420684"
                        )
                    ]
                ),
                array(
                    "name"=> "鄂州市",
                    "code"=> "420700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420701"
                        ),
                        array(
                            "name"=> "梁子湖区",
                            "code"=> "420702"
                        ),
                        array(
                            "name"=> "华容区",
                            "code"=> "420703"
                        ),
                        array(
                            "name"=> "鄂城区",
                            "code"=> "420704"
                        )
                    ]
                ),
                array(
                    "name"=> "荆门市",
                    "code"=> "420800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420801"
                        ),
                        array(
                            "name"=> "东宝区",
                            "code"=> "420802"
                        ),
                        array(
                            "name"=> "掇刀区",
                            "code"=> "420804"
                        ),
                        array(
                            "name"=> "京山县",
                            "code"=> "420821"
                        ),
                        array(
                            "name"=> "沙洋县",
                            "code"=> "420822"
                        ),
                        array(
                            "name"=> "钟祥市",
                            "code"=> "420881"
                        )
                    ]
                ),
                array(
                    "name"=> "孝感市",
                    "code"=> "420900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "420901"
                        ),
                        array(
                            "name"=> "孝南区",
                            "code"=> "420902"
                        ),
                        array(
                            "name"=> "孝昌县",
                            "code"=> "420921"
                        ),
                        array(
                            "name"=> "大悟县",
                            "code"=> "420922"
                        ),
                        array(
                            "name"=> "云梦县",
                            "code"=> "420923"
                        ),
                        array(
                            "name"=> "应城市",
                            "code"=> "420981"
                        ),
                        array(
                            "name"=> "安陆市",
                            "code"=> "420982"
                        ),
                        array(
                            "name"=> "汉川市",
                            "code"=> "420984"
                        )
                    ]
                ),
                array(
                    "name"=> "荆州市",
                    "code"=> "421000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "421001"
                        ),
                        array(
                            "name"=> "沙市区",
                            "code"=> "421002"
                        ),
                        array(
                            "name"=> "荆州区",
                            "code"=> "421003"
                        ),
                        array(
                            "name"=> "公安县",
                            "code"=> "421022"
                        ),
                        array(
                            "name"=> "监利县",
                            "code"=> "421023"
                        ),
                        array(
                            "name"=> "江陵县",
                            "code"=> "421024"
                        ),
                        array(
                            "name"=> "石首市",
                            "code"=> "421081"
                        ),
                        array(
                            "name"=> "洪湖市",
                            "code"=> "421083"
                        ),
                        array(
                            "name"=> "松滋市",
                            "code"=> "421087"
                        )
                    ]
                ),
                array(
                    "name"=> "黄冈市",
                    "code"=> "421100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "421101"
                        ),
                        array(
                            "name"=> "黄州区",
                            "code"=> "421102"
                        ),
                        array(
                            "name"=> "团风县",
                            "code"=> "421121"
                        ),
                        array(
                            "name"=> "红安县",
                            "code"=> "421122"
                        ),
                        array(
                            "name"=> "罗田县",
                            "code"=> "421123"
                        ),
                        array(
                            "name"=> "英山县",
                            "code"=> "421124"
                        ),
                        array(
                            "name"=> "浠水县",
                            "code"=> "421125"
                        ),
                        array(
                            "name"=> "蕲春县",
                            "code"=> "421126"
                        ),
                        array(
                            "name"=> "黄梅县",
                            "code"=> "421127"
                        ),
                        array(
                            "name"=> "麻城市",
                            "code"=> "421181"
                        ),
                        array(
                            "name"=> "武穴市",
                            "code"=> "421182"
                        )
                    ]
                ),
                array(
                    "name"=> "咸宁市",
                    "code"=> "421200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "421201"
                        ),
                        array(
                            "name"=> "咸安区",
                            "code"=> "421202"
                        ),
                        array(
                            "name"=> "嘉鱼县",
                            "code"=> "421221"
                        ),
                        array(
                            "name"=> "通城县",
                            "code"=> "421222"
                        ),
                        array(
                            "name"=> "崇阳县",
                            "code"=> "421223"
                        ),
                        array(
                            "name"=> "通山县",
                            "code"=> "421224"
                        ),
                        array(
                            "name"=> "赤壁市",
                            "code"=> "421281"
                        )
                    ]
                ),
                array(
                    "name"=> "随州市",
                    "code"=> "421300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "421301"
                        ),
                        array(
                            "name"=> "曾都区",
                            "code"=> "421303"
                        ),
                        array(
                            "name"=> "随县",
                            "code"=> "421321"
                        ),
                        array(
                            "name"=> "广水市",
                            "code"=> "421381"
                        )
                    ]
                ),
                array(
                    "name"=> "恩施土家族苗族自治州",
                    "code"=> "422800",
                    "sub"=> [
                        array(
                            "name"=> "恩施市",
                            "code"=> "422801"
                        ),
                        array(
                            "name"=> "利川市",
                            "code"=> "422802"
                        ),
                        array(
                            "name"=> "建始县",
                            "code"=> "422822"
                        ),
                        array(
                            "name"=> "巴东县",
                            "code"=> "422823"
                        ),
                        array(
                            "name"=> "宣恩县",
                            "code"=> "422825"
                        ),
                        array(
                            "name"=> "咸丰县",
                            "code"=> "422826"
                        ),
                        array(
                            "name"=> "来凤县",
                            "code"=> "422827"
                        ),
                        array(
                            "name"=> "鹤峰县",
                            "code"=> "422828"
                        )
                    ]
                ),
                array(
                    "name"=> "仙桃市",
                    "code"=> "429004"
                ),
                array(
                    "name"=> "潜江市",
                    "code"=> "429005"
                ),
                array(
                    "name"=> "天门市",
                    "code"=> "429006"
                ),
                array(
                    "name"=> "神农架林区",
                    "code"=> "429021"
                )
            ]
        ),
        array(
            "name"=> "湖南省",
            "code"=> "430000",
            "sub"=> [
                array(
                    "name"=> "长沙市",
                    "code"=> "430100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430101"
                        ),
                        array(
                            "name"=> "芙蓉区",
                            "code"=> "430102"
                        ),
                        array(
                            "name"=> "天心区",
                            "code"=> "430103"
                        ),
                        array(
                            "name"=> "岳麓区",
                            "code"=> "430104"
                        ),
                        array(
                            "name"=> "开福区",
                            "code"=> "430105"
                        ),
                        array(
                            "name"=> "雨花区",
                            "code"=> "430111"
                        ),
                        array(
                            "name"=> "望城区",
                            "code"=> "430112"
                        ),
                        array(
                            "name"=> "长沙县",
                            "code"=> "430121"
                        ),
                        array(
                            "name"=> "宁乡县",
                            "code"=> "430124"
                        ),
                        array(
                            "name"=> "浏阳市",
                            "code"=> "430181"
                        )
                    ]
                ),
                array(
                    "name"=> "株洲市",
                    "code"=> "430200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430201"
                        ),
                        array(
                            "name"=> "荷塘区",
                            "code"=> "430202"
                        ),
                        array(
                            "name"=> "芦淞区",
                            "code"=> "430203"
                        ),
                        array(
                            "name"=> "石峰区",
                            "code"=> "430204"
                        ),
                        array(
                            "name"=> "天元区",
                            "code"=> "430211"
                        ),
                        array(
                            "name"=> "株洲县",
                            "code"=> "430221"
                        ),
                        array(
                            "name"=> "攸县",
                            "code"=> "430223"
                        ),
                        array(
                            "name"=> "茶陵县",
                            "code"=> "430224"
                        ),
                        array(
                            "name"=> "炎陵县",
                            "code"=> "430225"
                        ),
                        array(
                            "name"=> "醴陵市",
                            "code"=> "430281"
                        )
                    ]
                ),
                array(
                    "name"=> "湘潭市",
                    "code"=> "430300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430301"
                        ),
                        array(
                            "name"=> "雨湖区",
                            "code"=> "430302"
                        ),
                        array(
                            "name"=> "岳塘区",
                            "code"=> "430304"
                        ),
                        array(
                            "name"=> "湘潭县",
                            "code"=> "430321"
                        ),
                        array(
                            "name"=> "湘乡市",
                            "code"=> "430381"
                        ),
                        array(
                            "name"=> "韶山市",
                            "code"=> "430382"
                        )
                    ]
                ),
                array(
                    "name"=> "衡阳市",
                    "code"=> "430400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430401"
                        ),
                        array(
                            "name"=> "珠晖区",
                            "code"=> "430405"
                        ),
                        array(
                            "name"=> "雁峰区",
                            "code"=> "430406"
                        ),
                        array(
                            "name"=> "石鼓区",
                            "code"=> "430407"
                        ),
                        array(
                            "name"=> "蒸湘区",
                            "code"=> "430408"
                        ),
                        array(
                            "name"=> "南岳区",
                            "code"=> "430412"
                        ),
                        array(
                            "name"=> "衡阳县",
                            "code"=> "430421"
                        ),
                        array(
                            "name"=> "衡南县",
                            "code"=> "430422"
                        ),
                        array(
                            "name"=> "衡山县",
                            "code"=> "430423"
                        ),
                        array(
                            "name"=> "衡东县",
                            "code"=> "430424"
                        ),
                        array(
                            "name"=> "祁东县",
                            "code"=> "430426"
                        ),
                        array(
                            "name"=> "耒阳市",
                            "code"=> "430481"
                        ),
                        array(
                            "name"=> "常宁市",
                            "code"=> "430482"
                        )
                    ]
                ),
                array(
                    "name"=> "邵阳市",
                    "code"=> "430500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430501"
                        ),
                        array(
                            "name"=> "双清区",
                            "code"=> "430502"
                        ),
                        array(
                            "name"=> "大祥区",
                            "code"=> "430503"
                        ),
                        array(
                            "name"=> "北塔区",
                            "code"=> "430511"
                        ),
                        array(
                            "name"=> "邵东县",
                            "code"=> "430521"
                        ),
                        array(
                            "name"=> "新邵县",
                            "code"=> "430522"
                        ),
                        array(
                            "name"=> "邵阳县",
                            "code"=> "430523"
                        ),
                        array(
                            "name"=> "隆回县",
                            "code"=> "430524"
                        ),
                        array(
                            "name"=> "洞口县",
                            "code"=> "430525"
                        ),
                        array(
                            "name"=> "绥宁县",
                            "code"=> "430527"
                        ),
                        array(
                            "name"=> "新宁县",
                            "code"=> "430528"
                        ),
                        array(
                            "name"=> "城步苗族自治县",
                            "code"=> "430529"
                        ),
                        array(
                            "name"=> "武冈市",
                            "code"=> "430581"
                        )
                    ]
                ),
                array(
                    "name"=> "岳阳市",
                    "code"=> "430600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430601"
                        ),
                        array(
                            "name"=> "岳阳楼区",
                            "code"=> "430602"
                        ),
                        array(
                            "name"=> "云溪区",
                            "code"=> "430603"
                        ),
                        array(
                            "name"=> "君山区",
                            "code"=> "430611"
                        ),
                        array(
                            "name"=> "岳阳县",
                            "code"=> "430621"
                        ),
                        array(
                            "name"=> "华容县",
                            "code"=> "430623"
                        ),
                        array(
                            "name"=> "湘阴县",
                            "code"=> "430624"
                        ),
                        array(
                            "name"=> "平江县",
                            "code"=> "430626"
                        ),
                        array(
                            "name"=> "汨罗市",
                            "code"=> "430681"
                        ),
                        array(
                            "name"=> "临湘市",
                            "code"=> "430682"
                        )
                    ]
                ),
                array(
                    "name"=> "常德市",
                    "code"=> "430700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430701"
                        ),
                        array(
                            "name"=> "武陵区",
                            "code"=> "430702"
                        ),
                        array(
                            "name"=> "鼎城区",
                            "code"=> "430703"
                        ),
                        array(
                            "name"=> "安乡县",
                            "code"=> "430721"
                        ),
                        array(
                            "name"=> "汉寿县",
                            "code"=> "430722"
                        ),
                        array(
                            "name"=> "澧县",
                            "code"=> "430723"
                        ),
                        array(
                            "name"=> "临澧县",
                            "code"=> "430724"
                        ),
                        array(
                            "name"=> "桃源县",
                            "code"=> "430725"
                        ),
                        array(
                            "name"=> "石门县",
                            "code"=> "430726"
                        ),
                        array(
                            "name"=> "津市市",
                            "code"=> "430781"
                        )
                    ]
                ),
                array(
                    "name"=> "张家界市",
                    "code"=> "430800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430801"
                        ),
                        array(
                            "name"=> "永定区",
                            "code"=> "430802"
                        ),
                        array(
                            "name"=> "武陵源区",
                            "code"=> "430811"
                        ),
                        array(
                            "name"=> "慈利县",
                            "code"=> "430821"
                        ),
                        array(
                            "name"=> "桑植县",
                            "code"=> "430822"
                        )
                    ]
                ),
                array(
                    "name"=> "益阳市",
                    "code"=> "430900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "430901"
                        ),
                        array(
                            "name"=> "资阳区",
                            "code"=> "430902"
                        ),
                        array(
                            "name"=> "赫山区",
                            "code"=> "430903"
                        ),
                        array(
                            "name"=> "南县",
                            "code"=> "430921"
                        ),
                        array(
                            "name"=> "桃江县",
                            "code"=> "430922"
                        ),
                        array(
                            "name"=> "安化县",
                            "code"=> "430923"
                        ),
                        array(
                            "name"=> "沅江市",
                            "code"=> "430981"
                        )
                    ]
                ),
                array(
                    "name"=> "郴州市",
                    "code"=> "431000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "431001"
                        ),
                        array(
                            "name"=> "北湖区",
                            "code"=> "431002"
                        ),
                        array(
                            "name"=> "苏仙区",
                            "code"=> "431003"
                        ),
                        array(
                            "name"=> "桂阳县",
                            "code"=> "431021"
                        ),
                        array(
                            "name"=> "宜章县",
                            "code"=> "431022"
                        ),
                        array(
                            "name"=> "永兴县",
                            "code"=> "431023"
                        ),
                        array(
                            "name"=> "嘉禾县",
                            "code"=> "431024"
                        ),
                        array(
                            "name"=> "临武县",
                            "code"=> "431025"
                        ),
                        array(
                            "name"=> "汝城县",
                            "code"=> "431026"
                        ),
                        array(
                            "name"=> "桂东县",
                            "code"=> "431027"
                        ),
                        array(
                            "name"=> "安仁县",
                            "code"=> "431028"
                        ),
                        array(
                            "name"=> "资兴市",
                            "code"=> "431081"
                        )
                    ]
                ),
                array(
                    "name"=> "永州市",
                    "code"=> "431100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "431101"
                        ),
                        array(
                            "name"=> "零陵区",
                            "code"=> "431102"
                        ),
                        array(
                            "name"=> "冷水滩区",
                            "code"=> "431103"
                        ),
                        array(
                            "name"=> "祁阳县",
                            "code"=> "431121"
                        ),
                        array(
                            "name"=> "东安县",
                            "code"=> "431122"
                        ),
                        array(
                            "name"=> "双牌县",
                            "code"=> "431123"
                        ),
                        array(
                            "name"=> "道县",
                            "code"=> "431124"
                        ),
                        array(
                            "name"=> "江永县",
                            "code"=> "431125"
                        ),
                        array(
                            "name"=> "宁远县",
                            "code"=> "431126"
                        ),
                        array(
                            "name"=> "蓝山县",
                            "code"=> "431127"
                        ),
                        array(
                            "name"=> "新田县",
                            "code"=> "431128"
                        ),
                        array(
                            "name"=> "江华瑶族自治县",
                            "code"=> "431129"
                        )
                    ]
                ),
                array(
                    "name"=> "怀化市",
                    "code"=> "431200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "431201"
                        ),
                        array(
                            "name"=> "鹤城区",
                            "code"=> "431202"
                        ),
                        array(
                            "name"=> "中方县",
                            "code"=> "431221"
                        ),
                        array(
                            "name"=> "沅陵县",
                            "code"=> "431222"
                        ),
                        array(
                            "name"=> "辰溪县",
                            "code"=> "431223"
                        ),
                        array(
                            "name"=> "溆浦县",
                            "code"=> "431224"
                        ),
                        array(
                            "name"=> "会同县",
                            "code"=> "431225"
                        ),
                        array(
                            "name"=> "麻阳苗族自治县",
                            "code"=> "431226"
                        ),
                        array(
                            "name"=> "新晃侗族自治县",
                            "code"=> "431227"
                        ),
                        array(
                            "name"=> "芷江侗族自治县",
                            "code"=> "431228"
                        ),
                        array(
                            "name"=> "靖州苗族侗族自治县",
                            "code"=> "431229"
                        ),
                        array(
                            "name"=> "通道侗族自治县",
                            "code"=> "431230"
                        ),
                        array(
                            "name"=> "洪江市",
                            "code"=> "431281"
                        )
                    ]
                ),
                array(
                    "name"=> "娄底市",
                    "code"=> "431300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "431301"
                        ),
                        array(
                            "name"=> "娄星区",
                            "code"=> "431302"
                        ),
                        array(
                            "name"=> "双峰县",
                            "code"=> "431321"
                        ),
                        array(
                            "name"=> "新化县",
                            "code"=> "431322"
                        ),
                        array(
                            "name"=> "冷水江市",
                            "code"=> "431381"
                        ),
                        array(
                            "name"=> "涟源市",
                            "code"=> "431382"
                        )
                    ]
                ),
                array(
                    "name"=> "湘西土家族苗族自治州",
                    "code"=> "433100",
                    "sub"=> [
                        array(
                            "name"=> "吉首市",
                            "code"=> "433101"
                        ),
                        array(
                            "name"=> "泸溪县",
                            "code"=> "433122"
                        ),
                        array(
                            "name"=> "凤凰县",
                            "code"=> "433123"
                        ),
                        array(
                            "name"=> "花垣县",
                            "code"=> "433124"
                        ),
                        array(
                            "name"=> "保靖县",
                            "code"=> "433125"
                        ),
                        array(
                            "name"=> "古丈县",
                            "code"=> "433126"
                        ),
                        array(
                            "name"=> "永顺县",
                            "code"=> "433127"
                        ),
                        array(
                            "name"=> "龙山县",
                            "code"=> "433130"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "广东省",
            "code"=> "440000",
            "sub"=> [
                array(
                    "name"=> "广州市",
                    "code"=> "440100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440101"
                        ),
                        array(
                            "name"=> "荔湾区",
                            "code"=> "440103"
                        ),
                        array(
                            "name"=> "越秀区",
                            "code"=> "440104"
                        ),
                        array(
                            "name"=> "海珠区",
                            "code"=> "440105"
                        ),
                        array(
                            "name"=> "天河区",
                            "code"=> "440106"
                        ),
                        array(
                            "name"=> "白云区",
                            "code"=> "440111"
                        ),
                        array(
                            "name"=> "黄埔区",
                            "code"=> "440112"
                        ),
                        array(
                            "name"=> "番禺区",
                            "code"=> "440113"
                        ),
                        array(
                            "name"=> "花都区",
                            "code"=> "440114"
                        ),
                        array(
                            "name"=> "南沙区",
                            "code"=> "440115"
                        ),
                        array(
                            "name"=> "从化区",
                            "code"=> "440117"
                        ),
                        array(
                            "name"=> "增城区",
                            "code"=> "440118"
                        )
                    ]
                ),
                array(
                    "name"=> "韶关市",
                    "code"=> "440200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440201"
                        ),
                        array(
                            "name"=> "武江区",
                            "code"=> "440203"
                        ),
                        array(
                            "name"=> "浈江区",
                            "code"=> "440204"
                        ),
                        array(
                            "name"=> "曲江区",
                            "code"=> "440205"
                        ),
                        array(
                            "name"=> "始兴县",
                            "code"=> "440222"
                        ),
                        array(
                            "name"=> "仁化县",
                            "code"=> "440224"
                        ),
                        array(
                            "name"=> "翁源县",
                            "code"=> "440229"
                        ),
                        array(
                            "name"=> "乳源瑶族自治县",
                            "code"=> "440232"
                        ),
                        array(
                            "name"=> "新丰县",
                            "code"=> "440233"
                        ),
                        array(
                            "name"=> "乐昌市",
                            "code"=> "440281"
                        ),
                        array(
                            "name"=> "南雄市",
                            "code"=> "440282"
                        )
                    ]
                ),
                array(
                    "name"=> "深圳市",
                    "code"=> "440300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440301"
                        ),
                        array(
                            "name"=> "罗湖区",
                            "code"=> "440303"
                        ),
                        array(
                            "name"=> "福田区",
                            "code"=> "440304"
                        ),
                        array(
                            "name"=> "南山区",
                            "code"=> "440305"
                        ),
                        array(
                            "name"=> "宝安区",
                            "code"=> "440306"
                        ),
                        array(
                            "name"=> "龙岗区",
                            "code"=> "440307"
                        ),
                        array(
                            "name"=> "盐田区",
                            "code"=> "440308"
                        )
                    ]
                ),
                array(
                    "name"=> "珠海市",
                    "code"=> "440400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440401"
                        ),
                        array(
                            "name"=> "香洲区",
                            "code"=> "440402"
                        ),
                        array(
                            "name"=> "斗门区",
                            "code"=> "440403"
                        ),
                        array(
                            "name"=> "金湾区",
                            "code"=> "440404"
                        )
                    ]
                ),
                array(
                    "name"=> "汕头市",
                    "code"=> "440500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440501"
                        ),
                        array(
                            "name"=> "龙湖区",
                            "code"=> "440507"
                        ),
                        array(
                            "name"=> "金平区",
                            "code"=> "440511"
                        ),
                        array(
                            "name"=> "濠江区",
                            "code"=> "440512"
                        ),
                        array(
                            "name"=> "潮阳区",
                            "code"=> "440513"
                        ),
                        array(
                            "name"=> "潮南区",
                            "code"=> "440514"
                        ),
                        array(
                            "name"=> "澄海区",
                            "code"=> "440515"
                        ),
                        array(
                            "name"=> "南澳县",
                            "code"=> "440523"
                        )
                    ]
                ),
                array(
                    "name"=> "佛山市",
                    "code"=> "440600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440601"
                        ),
                        array(
                            "name"=> "禅城区",
                            "code"=> "440604"
                        ),
                        array(
                            "name"=> "南海区",
                            "code"=> "440605"
                        ),
                        array(
                            "name"=> "顺德区",
                            "code"=> "440606"
                        ),
                        array(
                            "name"=> "三水区",
                            "code"=> "440607"
                        ),
                        array(
                            "name"=> "高明区",
                            "code"=> "440608"
                        )
                    ]
                ),
                array(
                    "name"=> "江门市",
                    "code"=> "440700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440701"
                        ),
                        array(
                            "name"=> "蓬江区",
                            "code"=> "440703"
                        ),
                        array(
                            "name"=> "江海区",
                            "code"=> "440704"
                        ),
                        array(
                            "name"=> "新会区",
                            "code"=> "440705"
                        ),
                        array(
                            "name"=> "台山市",
                            "code"=> "440781"
                        ),
                        array(
                            "name"=> "开平市",
                            "code"=> "440783"
                        ),
                        array(
                            "name"=> "鹤山市",
                            "code"=> "440784"
                        ),
                        array(
                            "name"=> "恩平市",
                            "code"=> "440785"
                        )
                    ]
                ),
                array(
                    "name"=> "湛江市",
                    "code"=> "440800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440801"
                        ),
                        array(
                            "name"=> "赤坎区",
                            "code"=> "440802"
                        ),
                        array(
                            "name"=> "霞山区",
                            "code"=> "440803"
                        ),
                        array(
                            "name"=> "坡头区",
                            "code"=> "440804"
                        ),
                        array(
                            "name"=> "麻章区",
                            "code"=> "440811"
                        ),
                        array(
                            "name"=> "遂溪县",
                            "code"=> "440823"
                        ),
                        array(
                            "name"=> "徐闻县",
                            "code"=> "440825"
                        ),
                        array(
                            "name"=> "廉江市",
                            "code"=> "440881"
                        ),
                        array(
                            "name"=> "雷州市",
                            "code"=> "440882"
                        ),
                        array(
                            "name"=> "吴川市",
                            "code"=> "440883"
                        )
                    ]
                ),
                array(
                    "name"=> "茂名市",
                    "code"=> "440900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "440901"
                        ),
                        array(
                            "name"=> "茂南区",
                            "code"=> "440902"
                        ),
                        array(
                            "name"=> "电白区",
                            "code"=> "440904"
                        ),
                        array(
                            "name"=> "高州市",
                            "code"=> "440981"
                        ),
                        array(
                            "name"=> "化州市",
                            "code"=> "440982"
                        ),
                        array(
                            "name"=> "信宜市",
                            "code"=> "440983"
                        )
                    ]
                ),
                array(
                    "name"=> "肇庆市",
                    "code"=> "441200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441201"
                        ),
                        array(
                            "name"=> "端州区",
                            "code"=> "441202"
                        ),
                        array(
                            "name"=> "鼎湖区",
                            "code"=> "441203"
                        ),
                        array(
                            "name"=> "广宁县",
                            "code"=> "441223"
                        ),
                        array(
                            "name"=> "怀集县",
                            "code"=> "441224"
                        ),
                        array(
                            "name"=> "封开县",
                            "code"=> "441225"
                        ),
                        array(
                            "name"=> "德庆县",
                            "code"=> "441226"
                        ),
                        array(
                            "name"=> "高要市",
                            "code"=> "441283"
                        ),
                        array(
                            "name"=> "四会市",
                            "code"=> "441284"
                        )
                    ]
                ),
                array(
                    "name"=> "惠州市",
                    "code"=> "441300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441301"
                        ),
                        array(
                            "name"=> "惠城区",
                            "code"=> "441302"
                        ),
                        array(
                            "name"=> "惠阳区",
                            "code"=> "441303"
                        ),
                        array(
                            "name"=> "博罗县",
                            "code"=> "441322"
                        ),
                        array(
                            "name"=> "惠东县",
                            "code"=> "441323"
                        ),
                        array(
                            "name"=> "龙门县",
                            "code"=> "441324"
                        )
                    ]
                ),
                array(
                    "name"=> "梅州市",
                    "code"=> "441400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441401"
                        ),
                        array(
                            "name"=> "梅江区",
                            "code"=> "441402"
                        ),
                        array(
                            "name"=> "梅县区",
                            "code"=> "441403"
                        ),
                        array(
                            "name"=> "大埔县",
                            "code"=> "441422"
                        ),
                        array(
                            "name"=> "丰顺县",
                            "code"=> "441423"
                        ),
                        array(
                            "name"=> "五华县",
                            "code"=> "441424"
                        ),
                        array(
                            "name"=> "平远县",
                            "code"=> "441426"
                        ),
                        array(
                            "name"=> "蕉岭县",
                            "code"=> "441427"
                        ),
                        array(
                            "name"=> "兴宁市",
                            "code"=> "441481"
                        )
                    ]
                ),
                array(
                    "name"=> "汕尾市",
                    "code"=> "441500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441501"
                        ),
                        array(
                            "name"=> "城区",
                            "code"=> "441502"
                        ),
                        array(
                            "name"=> "海丰县",
                            "code"=> "441521"
                        ),
                        array(
                            "name"=> "陆河县",
                            "code"=> "441523"
                        ),
                        array(
                            "name"=> "陆丰市",
                            "code"=> "441581"
                        )
                    ]
                ),
                array(
                    "name"=> "河源市",
                    "code"=> "441600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441601"
                        ),
                        array(
                            "name"=> "源城区",
                            "code"=> "441602"
                        ),
                        array(
                            "name"=> "紫金县",
                            "code"=> "441621"
                        ),
                        array(
                            "name"=> "龙川县",
                            "code"=> "441622"
                        ),
                        array(
                            "name"=> "连平县",
                            "code"=> "441623"
                        ),
                        array(
                            "name"=> "和平县",
                            "code"=> "441624"
                        ),
                        array(
                            "name"=> "东源县",
                            "code"=> "441625"
                        )
                    ]
                ),
                array(
                    "name"=> "阳江市",
                    "code"=> "441700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441701"
                        ),
                        array(
                            "name"=> "江城区",
                            "code"=> "441702"
                        ),
                        array(
                            "name"=> "阳东区",
                            "code"=> "441704"
                        ),
                        array(
                            "name"=> "阳西县",
                            "code"=> "441721"
                        ),
                        array(
                            "name"=> "阳春市",
                            "code"=> "441781"
                        )
                    ]
                ),
                array(
                    "name"=> "清远市",
                    "code"=> "441800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "441801"
                        ),
                        array(
                            "name"=> "清城区",
                            "code"=> "441802"
                        ),
                        array(
                            "name"=> "清新区",
                            "code"=> "441803"
                        ),
                        array(
                            "name"=> "佛冈县",
                            "code"=> "441821"
                        ),
                        array(
                            "name"=> "阳山县",
                            "code"=> "441823"
                        ),
                        array(
                            "name"=> "连山壮族瑶族自治县",
                            "code"=> "441825"
                        ),
                        array(
                            "name"=> "连南瑶族自治县",
                            "code"=> "441826"
                        ),
                        array(
                            "name"=> "英德市",
                            "code"=> "441881"
                        ),
                        array(
                            "name"=> "连州市",
                            "code"=> "441882"
                        )
                    ]
                ),
                array(
                    "name"=> "东莞市",
                    "code"=> "441900",
                    "sub"=> [
                    ]
                ),
                array(
                    "name"=> "中山市",
                    "code"=> "442000",
                    "sub"=> [
                    ]
                ),
                array(
                    "name"=> "潮州市",
                    "code"=> "445100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "445101"
                        ),
                        array(
                            "name"=> "湘桥区",
                            "code"=> "445102"
                        ),
                        array(
                            "name"=> "潮安区",
                            "code"=> "445103"
                        ),
                        array(
                            "name"=> "饶平县",
                            "code"=> "445122"
                        )
                    ]
                ),
                array(
                    "name"=> "揭阳市",
                    "code"=> "445200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "445201"
                        ),
                        array(
                            "name"=> "榕城区",
                            "code"=> "445202"
                        ),
                        array(
                            "name"=> "揭东区",
                            "code"=> "445203"
                        ),
                        array(
                            "name"=> "揭西县",
                            "code"=> "445222"
                        ),
                        array(
                            "name"=> "惠来县",
                            "code"=> "445224"
                        ),
                        array(
                            "name"=> "普宁市",
                            "code"=> "445281"
                        )
                    ]
                ),
                array(
                    "name"=> "云浮市",
                    "code"=> "445300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "445301"
                        ),
                        array(
                            "name"=> "云城区",
                            "code"=> "445302"
                        ),
                        array(
                            "name"=> "云安区",
                            "code"=> "445303"
                        ),
                        array(
                            "name"=> "新兴县",
                            "code"=> "445321"
                        ),
                        array(
                            "name"=> "郁南县",
                            "code"=> "445322"
                        ),
                        array(
                            "name"=> "罗定市",
                            "code"=> "445381"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "广西壮族自治区",
            "code"=> "450000",
            "sub"=> [
                array(
                    "name"=> "南宁市",
                    "code"=> "450100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450101"
                        ),
                        array(
                            "name"=> "兴宁区",
                            "code"=> "450102"
                        ),
                        array(
                            "name"=> "青秀区",
                            "code"=> "450103"
                        ),
                        array(
                            "name"=> "江南区",
                            "code"=> "450105"
                        ),
                        array(
                            "name"=> "西乡塘区",
                            "code"=> "450107"
                        ),
                        array(
                            "name"=> "良庆区",
                            "code"=> "450108"
                        ),
                        array(
                            "name"=> "邕宁区",
                            "code"=> "450109"
                        ),
                        array(
                            "name"=> "武鸣县",
                            "code"=> "450122"
                        ),
                        array(
                            "name"=> "隆安县",
                            "code"=> "450123"
                        ),
                        array(
                            "name"=> "马山县",
                            "code"=> "450124"
                        ),
                        array(
                            "name"=> "上林县",
                            "code"=> "450125"
                        ),
                        array(
                            "name"=> "宾阳县",
                            "code"=> "450126"
                        ),
                        array(
                            "name"=> "横县",
                            "code"=> "450127"
                        )
                    ]
                ),
                array(
                    "name"=> "柳州市",
                    "code"=> "450200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450201"
                        ),
                        array(
                            "name"=> "城中区",
                            "code"=> "450202"
                        ),
                        array(
                            "name"=> "鱼峰区",
                            "code"=> "450203"
                        ),
                        array(
                            "name"=> "柳南区",
                            "code"=> "450204"
                        ),
                        array(
                            "name"=> "柳北区",
                            "code"=> "450205"
                        ),
                        array(
                            "name"=> "柳江县",
                            "code"=> "450221"
                        ),
                        array(
                            "name"=> "柳城县",
                            "code"=> "450222"
                        ),
                        array(
                            "name"=> "鹿寨县",
                            "code"=> "450223"
                        ),
                        array(
                            "name"=> "融安县",
                            "code"=> "450224"
                        ),
                        array(
                            "name"=> "融水苗族自治县",
                            "code"=> "450225"
                        ),
                        array(
                            "name"=> "三江侗族自治县",
                            "code"=> "450226"
                        )
                    ]
                ),
                array(
                    "name"=> "桂林市",
                    "code"=> "450300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450301"
                        ),
                        array(
                            "name"=> "秀峰区",
                            "code"=> "450302"
                        ),
                        array(
                            "name"=> "叠彩区",
                            "code"=> "450303"
                        ),
                        array(
                            "name"=> "象山区",
                            "code"=> "450304"
                        ),
                        array(
                            "name"=> "七星区",
                            "code"=> "450305"
                        ),
                        array(
                            "name"=> "雁山区",
                            "code"=> "450311"
                        ),
                        array(
                            "name"=> "临桂区",
                            "code"=> "450312"
                        ),
                        array(
                            "name"=> "阳朔县",
                            "code"=> "450321"
                        ),
                        array(
                            "name"=> "灵川县",
                            "code"=> "450323"
                        ),
                        array(
                            "name"=> "全州县",
                            "code"=> "450324"
                        ),
                        array(
                            "name"=> "兴安县",
                            "code"=> "450325"
                        ),
                        array(
                            "name"=> "永福县",
                            "code"=> "450326"
                        ),
                        array(
                            "name"=> "灌阳县",
                            "code"=> "450327"
                        ),
                        array(
                            "name"=> "龙胜各族自治县",
                            "code"=> "450328"
                        ),
                        array(
                            "name"=> "资源县",
                            "code"=> "450329"
                        ),
                        array(
                            "name"=> "平乐县",
                            "code"=> "450330"
                        ),
                        array(
                            "name"=> "荔浦县",
                            "code"=> "450331"
                        ),
                        array(
                            "name"=> "恭城瑶族自治县",
                            "code"=> "450332"
                        )
                    ]
                ),
                array(
                    "name"=> "梧州市",
                    "code"=> "450400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450401"
                        ),
                        array(
                            "name"=> "万秀区",
                            "code"=> "450403"
                        ),
                        array(
                            "name"=> "长洲区",
                            "code"=> "450405"
                        ),
                        array(
                            "name"=> "龙圩区",
                            "code"=> "450406"
                        ),
                        array(
                            "name"=> "苍梧县",
                            "code"=> "450421"
                        ),
                        array(
                            "name"=> "藤县",
                            "code"=> "450422"
                        ),
                        array(
                            "name"=> "蒙山县",
                            "code"=> "450423"
                        ),
                        array(
                            "name"=> "岑溪市",
                            "code"=> "450481"
                        )
                    ]
                ),
                array(
                    "name"=> "北海市",
                    "code"=> "450500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450501"
                        ),
                        array(
                            "name"=> "海城区",
                            "code"=> "450502"
                        ),
                        array(
                            "name"=> "银海区",
                            "code"=> "450503"
                        ),
                        array(
                            "name"=> "铁山港区",
                            "code"=> "450512"
                        ),
                        array(
                            "name"=> "合浦县",
                            "code"=> "450521"
                        )
                    ]
                ),
                array(
                    "name"=> "防城港市",
                    "code"=> "450600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450601"
                        ),
                        array(
                            "name"=> "港口区",
                            "code"=> "450602"
                        ),
                        array(
                            "name"=> "防城区",
                            "code"=> "450603"
                        ),
                        array(
                            "name"=> "上思县",
                            "code"=> "450621"
                        ),
                        array(
                            "name"=> "东兴市",
                            "code"=> "450681"
                        )
                    ]
                ),
                array(
                    "name"=> "钦州市",
                    "code"=> "450700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450701"
                        ),
                        array(
                            "name"=> "钦南区",
                            "code"=> "450702"
                        ),
                        array(
                            "name"=> "钦北区",
                            "code"=> "450703"
                        ),
                        array(
                            "name"=> "灵山县",
                            "code"=> "450721"
                        ),
                        array(
                            "name"=> "浦北县",
                            "code"=> "450722"
                        )
                    ]
                ),
                array(
                    "name"=> "贵港市",
                    "code"=> "450800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450801"
                        ),
                        array(
                            "name"=> "港北区",
                            "code"=> "450802"
                        ),
                        array(
                            "name"=> "港南区",
                            "code"=> "450803"
                        ),
                        array(
                            "name"=> "覃塘区",
                            "code"=> "450804"
                        ),
                        array(
                            "name"=> "平南县",
                            "code"=> "450821"
                        ),
                        array(
                            "name"=> "桂平市",
                            "code"=> "450881"
                        )
                    ]
                ),
                array(
                    "name"=> "玉林市",
                    "code"=> "450900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "450901"
                        ),
                        array(
                            "name"=> "玉州区",
                            "code"=> "450902"
                        ),
                        array(
                            "name"=> "福绵区",
                            "code"=> "450903"
                        ),
                        array(
                            "name"=> "容县",
                            "code"=> "450921"
                        ),
                        array(
                            "name"=> "陆川县",
                            "code"=> "450922"
                        ),
                        array(
                            "name"=> "博白县",
                            "code"=> "450923"
                        ),
                        array(
                            "name"=> "兴业县",
                            "code"=> "450924"
                        ),
                        array(
                            "name"=> "北流市",
                            "code"=> "450981"
                        )
                    ]
                ),
                array(
                    "name"=> "百色市",
                    "code"=> "451000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "451001"
                        ),
                        array(
                            "name"=> "右江区",
                            "code"=> "451002"
                        ),
                        array(
                            "name"=> "田阳县",
                            "code"=> "451021"
                        ),
                        array(
                            "name"=> "田东县",
                            "code"=> "451022"
                        ),
                        array(
                            "name"=> "平果县",
                            "code"=> "451023"
                        ),
                        array(
                            "name"=> "德保县",
                            "code"=> "451024"
                        ),
                        array(
                            "name"=> "靖西县",
                            "code"=> "451025"
                        ),
                        array(
                            "name"=> "那坡县",
                            "code"=> "451026"
                        ),
                        array(
                            "name"=> "凌云县",
                            "code"=> "451027"
                        ),
                        array(
                            "name"=> "乐业县",
                            "code"=> "451028"
                        ),
                        array(
                            "name"=> "田林县",
                            "code"=> "451029"
                        ),
                        array(
                            "name"=> "西林县",
                            "code"=> "451030"
                        ),
                        array(
                            "name"=> "隆林各族自治县",
                            "code"=> "451031"
                        )
                    ]
                ),
                array(
                    "name"=> "贺州市",
                    "code"=> "451100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "451101"
                        ),
                        array(
                            "name"=> "八步区",
                            "code"=> "451102"
                        ),
                        array(
                            "name"=> "平桂管理区",
                            "code"=> "451119"
                        ),
                        array(
                            "name"=> "昭平县",
                            "code"=> "451121"
                        ),
                        array(
                            "name"=> "钟山县",
                            "code"=> "451122"
                        ),
                        array(
                            "name"=> "富川瑶族自治县",
                            "code"=> "451123"
                        )
                    ]
                ),
                array(
                    "name"=> "河池市",
                    "code"=> "451200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "451201"
                        ),
                        array(
                            "name"=> "金城江区",
                            "code"=> "451202"
                        ),
                        array(
                            "name"=> "南丹县",
                            "code"=> "451221"
                        ),
                        array(
                            "name"=> "天峨县",
                            "code"=> "451222"
                        ),
                        array(
                            "name"=> "凤山县",
                            "code"=> "451223"
                        ),
                        array(
                            "name"=> "东兰县",
                            "code"=> "451224"
                        ),
                        array(
                            "name"=> "罗城仫佬族自治县",
                            "code"=> "451225"
                        ),
                        array(
                            "name"=> "环江毛南族自治县",
                            "code"=> "451226"
                        ),
                        array(
                            "name"=> "巴马瑶族自治县",
                            "code"=> "451227"
                        ),
                        array(
                            "name"=> "都安瑶族自治县",
                            "code"=> "451228"
                        ),
                        array(
                            "name"=> "大化瑶族自治县",
                            "code"=> "451229"
                        ),
                        array(
                            "name"=> "宜州市",
                            "code"=> "451281"
                        )
                    ]
                ),
                array(
                    "name"=> "来宾市",
                    "code"=> "451300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "451301"
                        ),
                        array(
                            "name"=> "兴宾区",
                            "code"=> "451302"
                        ),
                        array(
                            "name"=> "忻城县",
                            "code"=> "451321"
                        ),
                        array(
                            "name"=> "象州县",
                            "code"=> "451322"
                        ),
                        array(
                            "name"=> "武宣县",
                            "code"=> "451323"
                        ),
                        array(
                            "name"=> "金秀瑶族自治县",
                            "code"=> "451324"
                        ),
                        array(
                            "name"=> "合山市",
                            "code"=> "451381"
                        )
                    ]
                ),
                array(
                    "name"=> "崇左市",
                    "code"=> "451400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "451401"
                        ),
                        array(
                            "name"=> "江州区",
                            "code"=> "451402"
                        ),
                        array(
                            "name"=> "扶绥县",
                            "code"=> "451421"
                        ),
                        array(
                            "name"=> "宁明县",
                            "code"=> "451422"
                        ),
                        array(
                            "name"=> "龙州县",
                            "code"=> "451423"
                        ),
                        array(
                            "name"=> "大新县",
                            "code"=> "451424"
                        ),
                        array(
                            "name"=> "天等县",
                            "code"=> "451425"
                        ),
                        array(
                            "name"=> "凭祥市",
                            "code"=> "451481"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "海南省",
            "code"=> "460000",
            "sub"=> [
                array(
                    "name"=> "海口市",
                    "code"=> "460100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "460101"
                        ),
                        array(
                            "name"=> "秀英区",
                            "code"=> "460105"
                        ),
                        array(
                            "name"=> "龙华区",
                            "code"=> "460106"
                        ),
                        array(
                            "name"=> "琼山区",
                            "code"=> "460107"
                        ),
                        array(
                            "name"=> "美兰区",
                            "code"=> "460108"
                        )
                    ]
                ),
                array(
                    "name"=> "三亚市",
                    "code"=> "460200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "460201"
                        ),
                        array(
                            "name"=> "海棠区",
                            "code"=> "460202"
                        ),
                        array(
                            "name"=> "吉阳区",
                            "code"=> "460203"
                        ),
                        array(
                            "name"=> "天涯区",
                            "code"=> "460204"
                        ),
                        array(
                            "name"=> "崖州区",
                            "code"=> "460205"
                        )
                    ]
                ),
                array(
                    "name"=> "三沙市",
                    "code"=> "460300",
                    "sub"=> [
                        array(
                            "name"=> "西沙群岛",
                            "code"=> "460321"
                        ),
                        array(
                            "name"=> "南沙群岛",
                            "code"=> "460322"
                        ),
                        array(
                            "name"=> "中沙群岛的岛礁及其海域",
                            "code"=> "460323"
                        )
                    ]
                ),
                array(
                    "name"=> "五指山市",
                    "code"=> "469001"
                ),
                array(
                    "name"=> "琼海市",
                    "code"=> "469002"
                ),
                array(
                    "name"=> "儋州市",
                    "code"=> "469003"
                ),
                array(
                    "name"=> "文昌市",
                    "code"=> "469005"
                ),
                array(
                    "name"=> "万宁市",
                    "code"=> "469006"
                ),
                array(
                    "name"=> "东方市",
                    "code"=> "469007"
                ),
                array(
                    "name"=> "定安县",
                    "code"=> "469021"
                ),
                array(
                    "name"=> "屯昌县",
                    "code"=> "469022"
                ),
                array(
                    "name"=> "澄迈县",
                    "code"=> "469023"
                ),
                array(
                    "name"=> "临高县",
                    "code"=> "469024"
                ),
                array(
                    "name"=> "白沙黎族自治县",
                    "code"=> "469025"
                ),
                array(
                    "name"=> "昌江黎族自治县",
                    "code"=> "469026"
                ),
                array(
                    "name"=> "乐东黎族自治县",
                    "code"=> "469027"
                ),
                array(
                    "name"=> "陵水黎族自治县",
                    "code"=> "469028"
                ),
                array(
                    "name"=> "保亭黎族苗族自治县",
                    "code"=> "469029"
                ),
                array(
                    "name"=> "琼中黎族苗族自治县",
                    "code"=> "469030"
                )
            ]
        ),
        array(
            "name"=> "重庆",
            "code"=> "500000",
            "sub"=> [
                array(
                    "name"=> "重庆市",
                    "code"=> "500000",
                    "sub"=> [
                        array(
                            "name"=> "万州区",
                            "code"=> "500101"
                        ),
                        array(
                            "name"=> "涪陵区",
                            "code"=> "500102"
                        ),
                        array(
                            "name"=> "渝中区",
                            "code"=> "500103"
                        ),
                        array(
                            "name"=> "大渡口区",
                            "code"=> "500104"
                        ),
                        array(
                            "name"=> "江北区",
                            "code"=> "500105"
                        ),
                        array(
                            "name"=> "沙坪坝区",
                            "code"=> "500106"
                        ),
                        array(
                            "name"=> "九龙坡区",
                            "code"=> "500107"
                        ),
                        array(
                            "name"=> "南岸区",
                            "code"=> "500108"
                        ),
                        array(
                            "name"=> "北碚区",
                            "code"=> "500109"
                        ),
                        array(
                            "name"=> "綦江区",
                            "code"=> "500110"
                        ),
                        array(
                            "name"=> "大足区",
                            "code"=> "500111"
                        ),
                        array(
                            "name"=> "渝北区",
                            "code"=> "500112"
                        ),
                        array(
                            "name"=> "巴南区",
                            "code"=> "500113"
                        ),
                        array(
                            "name"=> "黔江区",
                            "code"=> "500114"
                        ),
                        array(
                            "name"=> "长寿区",
                            "code"=> "500115"
                        ),
                        array(
                            "name"=> "江津区",
                            "code"=> "500116"
                        ),
                        array(
                            "name"=> "合川区",
                            "code"=> "500117"
                        ),
                        array(
                            "name"=> "永川区",
                            "code"=> "500118"
                        ),
                        array(
                            "name"=> "南川区",
                            "code"=> "500119"
                        ),
                        array(
                            "name"=> "璧山区",
                            "code"=> "500120"
                        ),
                        array(
                            "name"=> "铜梁区",
                            "code"=> "500151"
                        ),
                        array(
                            "name"=> "潼南县",
                            "code"=> "500223"
                        ),
                        array(
                            "name"=> "荣昌县",
                            "code"=> "500226"
                        ),
                        array(
                            "name"=> "梁平县",
                            "code"=> "500228"
                        ),
                        array(
                            "name"=> "城口县",
                            "code"=> "500229"
                        ),
                        array(
                            "name"=> "丰都县",
                            "code"=> "500230"
                        ),
                        array(
                            "name"=> "垫江县",
                            "code"=> "500231"
                        ),
                        array(
                            "name"=> "武隆县",
                            "code"=> "500232"
                        ),
                        array(
                            "name"=> "忠县",
                            "code"=> "500233"
                        ),
                        array(
                            "name"=> "开县",
                            "code"=> "500234"
                        ),
                        array(
                            "name"=> "云阳县",
                            "code"=> "500235"
                        ),
                        array(
                            "name"=> "奉节县",
                            "code"=> "500236"
                        ),
                        array(
                            "name"=> "巫山县",
                            "code"=> "500237"
                        ),
                        array(
                            "name"=> "巫溪县",
                            "code"=> "500238"
                        ),
                        array(
                            "name"=> "石柱土家族自治县",
                            "code"=> "500240"
                        ),
                        array(
                            "name"=> "秀山土家族苗族自治县",
                            "code"=> "500241"
                        ),
                        array(
                            "name"=> "酉阳土家族苗族自治县",
                            "code"=> "500242"
                        ),
                        array(
                            "name"=> "彭水苗族土家族自治县",
                            "code"=> "500243"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "四川省",
            "code"=> "510000",
            "sub"=> [
                array(
                    "name"=> "成都市",
                    "code"=> "510100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510101"
                        ),
                        array(
                            "name"=> "锦江区",
                            "code"=> "510104"
                        ),
                        array(
                            "name"=> "青羊区",
                            "code"=> "510105"
                        ),
                        array(
                            "name"=> "金牛区",
                            "code"=> "510106"
                        ),
                        array(
                            "name"=> "武侯区",
                            "code"=> "510107"
                        ),
                        array(
                            "name"=> "成华区",
                            "code"=> "510108"
                        ),
                        array(
                            "name"=> "龙泉驿区",
                            "code"=> "510112"
                        ),
                        array(
                            "name"=> "青白江区",
                            "code"=> "510113"
                        ),
                        array(
                            "name"=> "新都区",
                            "code"=> "510114"
                        ),
                        array(
                            "name"=> "温江区",
                            "code"=> "510115"
                        ),
                        array(
                            "name"=> "金堂县",
                            "code"=> "510121"
                        ),
                        array(
                            "name"=> "双流县",
                            "code"=> "510122"
                        ),
                        array(
                            "name"=> "郫县",
                            "code"=> "510124"
                        ),
                        array(
                            "name"=> "大邑县",
                            "code"=> "510129"
                        ),
                        array(
                            "name"=> "蒲江县",
                            "code"=> "510131"
                        ),
                        array(
                            "name"=> "新津县",
                            "code"=> "510132"
                        ),
                        array(
                            "name"=> "都江堰市",
                            "code"=> "510181"
                        ),
                        array(
                            "name"=> "彭州市",
                            "code"=> "510182"
                        ),
                        array(
                            "name"=> "邛崃市",
                            "code"=> "510183"
                        ),
                        array(
                            "name"=> "崇州市",
                            "code"=> "510184"
                        )
                    ]
                ),
                array(
                    "name"=> "自贡市",
                    "code"=> "510300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510301"
                        ),
                        array(
                            "name"=> "自流井区",
                            "code"=> "510302"
                        ),
                        array(
                            "name"=> "贡井区",
                            "code"=> "510303"
                        ),
                        array(
                            "name"=> "大安区",
                            "code"=> "510304"
                        ),
                        array(
                            "name"=> "沿滩区",
                            "code"=> "510311"
                        ),
                        array(
                            "name"=> "荣县",
                            "code"=> "510321"
                        ),
                        array(
                            "name"=> "富顺县",
                            "code"=> "510322"
                        )
                    ]
                ),
                array(
                    "name"=> "攀枝花市",
                    "code"=> "510400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510401"
                        ),
                        array(
                            "name"=> "东区",
                            "code"=> "510402"
                        ),
                        array(
                            "name"=> "西区",
                            "code"=> "510403"
                        ),
                        array(
                            "name"=> "仁和区",
                            "code"=> "510411"
                        ),
                        array(
                            "name"=> "米易县",
                            "code"=> "510421"
                        ),
                        array(
                            "name"=> "盐边县",
                            "code"=> "510422"
                        )
                    ]
                ),
                array(
                    "name"=> "泸州市",
                    "code"=> "510500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510501"
                        ),
                        array(
                            "name"=> "江阳区",
                            "code"=> "510502"
                        ),
                        array(
                            "name"=> "纳溪区",
                            "code"=> "510503"
                        ),
                        array(
                            "name"=> "龙马潭区",
                            "code"=> "510504"
                        ),
                        array(
                            "name"=> "泸县",
                            "code"=> "510521"
                        ),
                        array(
                            "name"=> "合江县",
                            "code"=> "510522"
                        ),
                        array(
                            "name"=> "叙永县",
                            "code"=> "510524"
                        ),
                        array(
                            "name"=> "古蔺县",
                            "code"=> "510525"
                        )
                    ]
                ),
                array(
                    "name"=> "德阳市",
                    "code"=> "510600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510601"
                        ),
                        array(
                            "name"=> "旌阳区",
                            "code"=> "510603"
                        ),
                        array(
                            "name"=> "中江县",
                            "code"=> "510623"
                        ),
                        array(
                            "name"=> "罗江县",
                            "code"=> "510626"
                        ),
                        array(
                            "name"=> "广汉市",
                            "code"=> "510681"
                        ),
                        array(
                            "name"=> "什邡市",
                            "code"=> "510682"
                        ),
                        array(
                            "name"=> "绵竹市",
                            "code"=> "510683"
                        )
                    ]
                ),
                array(
                    "name"=> "绵阳市",
                    "code"=> "510700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510701"
                        ),
                        array(
                            "name"=> "涪城区",
                            "code"=> "510703"
                        ),
                        array(
                            "name"=> "游仙区",
                            "code"=> "510704"
                        ),
                        array(
                            "name"=> "三台县",
                            "code"=> "510722"
                        ),
                        array(
                            "name"=> "盐亭县",
                            "code"=> "510723"
                        ),
                        array(
                            "name"=> "安县",
                            "code"=> "510724"
                        ),
                        array(
                            "name"=> "梓潼县",
                            "code"=> "510725"
                        ),
                        array(
                            "name"=> "北川羌族自治县",
                            "code"=> "510726"
                        ),
                        array(
                            "name"=> "平武县",
                            "code"=> "510727"
                        ),
                        array(
                            "name"=> "江油市",
                            "code"=> "510781"
                        )
                    ]
                ),
                array(
                    "name"=> "广元市",
                    "code"=> "510800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510801"
                        ),
                        array(
                            "name"=> "利州区",
                            "code"=> "510802"
                        ),
                        array(
                            "name"=> "昭化区",
                            "code"=> "510811"
                        ),
                        array(
                            "name"=> "朝天区",
                            "code"=> "510812"
                        ),
                        array(
                            "name"=> "旺苍县",
                            "code"=> "510821"
                        ),
                        array(
                            "name"=> "青川县",
                            "code"=> "510822"
                        ),
                        array(
                            "name"=> "剑阁县",
                            "code"=> "510823"
                        ),
                        array(
                            "name"=> "苍溪县",
                            "code"=> "510824"
                        )
                    ]
                ),
                array(
                    "name"=> "遂宁市",
                    "code"=> "510900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "510901"
                        ),
                        array(
                            "name"=> "船山区",
                            "code"=> "510903"
                        ),
                        array(
                            "name"=> "安居区",
                            "code"=> "510904"
                        ),
                        array(
                            "name"=> "蓬溪县",
                            "code"=> "510921"
                        ),
                        array(
                            "name"=> "射洪县",
                            "code"=> "510922"
                        ),
                        array(
                            "name"=> "大英县",
                            "code"=> "510923"
                        )
                    ]
                ),
                array(
                    "name"=> "内江市",
                    "code"=> "511000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511001"
                        ),
                        array(
                            "name"=> "市中区",
                            "code"=> "511002"
                        ),
                        array(
                            "name"=> "东兴区",
                            "code"=> "511011"
                        ),
                        array(
                            "name"=> "威远县",
                            "code"=> "511024"
                        ),
                        array(
                            "name"=> "资中县",
                            "code"=> "511025"
                        ),
                        array(
                            "name"=> "隆昌县",
                            "code"=> "511028"
                        )
                    ]
                ),
                array(
                    "name"=> "乐山市",
                    "code"=> "511100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511101"
                        ),
                        array(
                            "name"=> "市中区",
                            "code"=> "511102"
                        ),
                        array(
                            "name"=> "沙湾区",
                            "code"=> "511111"
                        ),
                        array(
                            "name"=> "五通桥区",
                            "code"=> "511112"
                        ),
                        array(
                            "name"=> "金口河区",
                            "code"=> "511113"
                        ),
                        array(
                            "name"=> "犍为县",
                            "code"=> "511123"
                        ),
                        array(
                            "name"=> "井研县",
                            "code"=> "511124"
                        ),
                        array(
                            "name"=> "夹江县",
                            "code"=> "511126"
                        ),
                        array(
                            "name"=> "沐川县",
                            "code"=> "511129"
                        ),
                        array(
                            "name"=> "峨边彝族自治县",
                            "code"=> "511132"
                        ),
                        array(
                            "name"=> "马边彝族自治县",
                            "code"=> "511133"
                        ),
                        array(
                            "name"=> "峨眉山市",
                            "code"=> "511181"
                        )
                    ]
                ),
                array(
                    "name"=> "南充市",
                    "code"=> "511300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511301"
                        ),
                        array(
                            "name"=> "顺庆区",
                            "code"=> "511302"
                        ),
                        array(
                            "name"=> "高坪区",
                            "code"=> "511303"
                        ),
                        array(
                            "name"=> "嘉陵区",
                            "code"=> "511304"
                        ),
                        array(
                            "name"=> "南部县",
                            "code"=> "511321"
                        ),
                        array(
                            "name"=> "营山县",
                            "code"=> "511322"
                        ),
                        array(
                            "name"=> "蓬安县",
                            "code"=> "511323"
                        ),
                        array(
                            "name"=> "仪陇县",
                            "code"=> "511324"
                        ),
                        array(
                            "name"=> "西充县",
                            "code"=> "511325"
                        ),
                        array(
                            "name"=> "阆中市",
                            "code"=> "511381"
                        )
                    ]
                ),
                array(
                    "name"=> "眉山市",
                    "code"=> "511400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511401"
                        ),
                        array(
                            "name"=> "东坡区",
                            "code"=> "511402"
                        ),
                        array(
                            "name"=> "彭山区",
                            "code"=> "511403"
                        ),
                        array(
                            "name"=> "仁寿县",
                            "code"=> "511421"
                        ),
                        array(
                            "name"=> "洪雅县",
                            "code"=> "511423"
                        ),
                        array(
                            "name"=> "丹棱县",
                            "code"=> "511424"
                        ),
                        array(
                            "name"=> "青神县",
                            "code"=> "511425"
                        )
                    ]
                ),
                array(
                    "name"=> "宜宾市",
                    "code"=> "511500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511501"
                        ),
                        array(
                            "name"=> "翠屏区",
                            "code"=> "511502"
                        ),
                        array(
                            "name"=> "南溪区",
                            "code"=> "511503"
                        ),
                        array(
                            "name"=> "宜宾县",
                            "code"=> "511521"
                        ),
                        array(
                            "name"=> "江安县",
                            "code"=> "511523"
                        ),
                        array(
                            "name"=> "长宁县",
                            "code"=> "511524"
                        ),
                        array(
                            "name"=> "高县",
                            "code"=> "511525"
                        ),
                        array(
                            "name"=> "珙县",
                            "code"=> "511526"
                        ),
                        array(
                            "name"=> "筠连县",
                            "code"=> "511527"
                        ),
                        array(
                            "name"=> "兴文县",
                            "code"=> "511528"
                        ),
                        array(
                            "name"=> "屏山县",
                            "code"=> "511529"
                        )
                    ]
                ),
                array(
                    "name"=> "广安市",
                    "code"=> "511600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511601"
                        ),
                        array(
                            "name"=> "广安区",
                            "code"=> "511602"
                        ),
                        array(
                            "name"=> "前锋区",
                            "code"=> "511603"
                        ),
                        array(
                            "name"=> "岳池县",
                            "code"=> "511621"
                        ),
                        array(
                            "name"=> "武胜县",
                            "code"=> "511622"
                        ),
                        array(
                            "name"=> "邻水县",
                            "code"=> "511623"
                        ),
                        array(
                            "name"=> "华蓥市",
                            "code"=> "511681"
                        )
                    ]
                ),
                array(
                    "name"=> "达州市",
                    "code"=> "511700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511701"
                        ),
                        array(
                            "name"=> "通川区",
                            "code"=> "511702"
                        ),
                        array(
                            "name"=> "达川区",
                            "code"=> "511703"
                        ),
                        array(
                            "name"=> "宣汉县",
                            "code"=> "511722"
                        ),
                        array(
                            "name"=> "开江县",
                            "code"=> "511723"
                        ),
                        array(
                            "name"=> "大竹县",
                            "code"=> "511724"
                        ),
                        array(
                            "name"=> "渠县",
                            "code"=> "511725"
                        ),
                        array(
                            "name"=> "万源市",
                            "code"=> "511781"
                        )
                    ]
                ),
                array(
                    "name"=> "雅安市",
                    "code"=> "511800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511801"
                        ),
                        array(
                            "name"=> "雨城区",
                            "code"=> "511802"
                        ),
                        array(
                            "name"=> "名山区",
                            "code"=> "511803"
                        ),
                        array(
                            "name"=> "荥经县",
                            "code"=> "511822"
                        ),
                        array(
                            "name"=> "汉源县",
                            "code"=> "511823"
                        ),
                        array(
                            "name"=> "石棉县",
                            "code"=> "511824"
                        ),
                        array(
                            "name"=> "天全县",
                            "code"=> "511825"
                        ),
                        array(
                            "name"=> "芦山县",
                            "code"=> "511826"
                        ),
                        array(
                            "name"=> "宝兴县",
                            "code"=> "511827"
                        )
                    ]
                ),
                array(
                    "name"=> "巴中市",
                    "code"=> "511900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "511901"
                        ),
                        array(
                            "name"=> "巴州区",
                            "code"=> "511902"
                        ),
                        array(
                            "name"=> "恩阳区",
                            "code"=> "511903"
                        ),
                        array(
                            "name"=> "通江县",
                            "code"=> "511921"
                        ),
                        array(
                            "name"=> "南江县",
                            "code"=> "511922"
                        ),
                        array(
                            "name"=> "平昌县",
                            "code"=> "511923"
                        )
                    ]
                ),
                array(
                    "name"=> "资阳市",
                    "code"=> "512000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "512001"
                        ),
                        array(
                            "name"=> "雁江区",
                            "code"=> "512002"
                        ),
                        array(
                            "name"=> "安岳县",
                            "code"=> "512021"
                        ),
                        array(
                            "name"=> "乐至县",
                            "code"=> "512022"
                        ),
                        array(
                            "name"=> "简阳市",
                            "code"=> "512081"
                        )
                    ]
                ),
                array(
                    "name"=> "阿坝藏族羌族自治州",
                    "code"=> "513200",
                    "sub"=> [
                        array(
                            "name"=> "汶川县",
                            "code"=> "513221"
                        ),
                        array(
                            "name"=> "理县",
                            "code"=> "513222"
                        ),
                        array(
                            "name"=> "茂县",
                            "code"=> "513223"
                        ),
                        array(
                            "name"=> "松潘县",
                            "code"=> "513224"
                        ),
                        array(
                            "name"=> "九寨沟县",
                            "code"=> "513225"
                        ),
                        array(
                            "name"=> "金川县",
                            "code"=> "513226"
                        ),
                        array(
                            "name"=> "小金县",
                            "code"=> "513227"
                        ),
                        array(
                            "name"=> "黑水县",
                            "code"=> "513228"
                        ),
                        array(
                            "name"=> "马尔康县",
                            "code"=> "513229"
                        ),
                        array(
                            "name"=> "壤塘县",
                            "code"=> "513230"
                        ),
                        array(
                            "name"=> "阿坝县",
                            "code"=> "513231"
                        ),
                        array(
                            "name"=> "若尔盖县",
                            "code"=> "513232"
                        ),
                        array(
                            "name"=> "红原县",
                            "code"=> "513233"
                        )
                    ]
                ),
                array(
                    "name"=> "甘孜藏族自治州",
                    "code"=> "513300",
                    "sub"=> [
                        array(
                            "name"=> "康定县",
                            "code"=> "513321"
                        ),
                        array(
                            "name"=> "泸定县",
                            "code"=> "513322"
                        ),
                        array(
                            "name"=> "丹巴县",
                            "code"=> "513323"
                        ),
                        array(
                            "name"=> "九龙县",
                            "code"=> "513324"
                        ),
                        array(
                            "name"=> "雅江县",
                            "code"=> "513325"
                        ),
                        array(
                            "name"=> "道孚县",
                            "code"=> "513326"
                        ),
                        array(
                            "name"=> "炉霍县",
                            "code"=> "513327"
                        ),
                        array(
                            "name"=> "甘孜县",
                            "code"=> "513328"
                        ),
                        array(
                            "name"=> "新龙县",
                            "code"=> "513329"
                        ),
                        array(
                            "name"=> "德格县",
                            "code"=> "513330"
                        ),
                        array(
                            "name"=> "白玉县",
                            "code"=> "513331"
                        ),
                        array(
                            "name"=> "石渠县",
                            "code"=> "513332"
                        ),
                        array(
                            "name"=> "色达县",
                            "code"=> "513333"
                        ),
                        array(
                            "name"=> "理塘县",
                            "code"=> "513334"
                        ),
                        array(
                            "name"=> "巴塘县",
                            "code"=> "513335"
                        ),
                        array(
                            "name"=> "乡城县",
                            "code"=> "513336"
                        ),
                        array(
                            "name"=> "稻城县",
                            "code"=> "513337"
                        ),
                        array(
                            "name"=> "得荣县",
                            "code"=> "513338"
                        )
                    ]
                ),
                array(
                    "name"=> "凉山彝族自治州",
                    "code"=> "513400",
                    "sub"=> [
                        array(
                            "name"=> "西昌市",
                            "code"=> "513401"
                        ),
                        array(
                            "name"=> "木里藏族自治县",
                            "code"=> "513422"
                        ),
                        array(
                            "name"=> "盐源县",
                            "code"=> "513423"
                        ),
                        array(
                            "name"=> "德昌县",
                            "code"=> "513424"
                        ),
                        array(
                            "name"=> "会理县",
                            "code"=> "513425"
                        ),
                        array(
                            "name"=> "会东县",
                            "code"=> "513426"
                        ),
                        array(
                            "name"=> "宁南县",
                            "code"=> "513427"
                        ),
                        array(
                            "name"=> "普格县",
                            "code"=> "513428"
                        ),
                        array(
                            "name"=> "布拖县",
                            "code"=> "513429"
                        ),
                        array(
                            "name"=> "金阳县",
                            "code"=> "513430"
                        ),
                        array(
                            "name"=> "昭觉县",
                            "code"=> "513431"
                        ),
                        array(
                            "name"=> "喜德县",
                            "code"=> "513432"
                        ),
                        array(
                            "name"=> "冕宁县",
                            "code"=> "513433"
                        ),
                        array(
                            "name"=> "越西县",
                            "code"=> "513434"
                        ),
                        array(
                            "name"=> "甘洛县",
                            "code"=> "513435"
                        ),
                        array(
                            "name"=> "美姑县",
                            "code"=> "513436"
                        ),
                        array(
                            "name"=> "雷波县",
                            "code"=> "513437"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "贵州省",
            "code"=> "520000",
            "sub"=> [
                array(
                    "name"=> "贵阳市",
                    "code"=> "520100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "520101"
                        ),
                        array(
                            "name"=> "南明区",
                            "code"=> "520102"
                        ),
                        array(
                            "name"=> "云岩区",
                            "code"=> "520103"
                        ),
                        array(
                            "name"=> "花溪区",
                            "code"=> "520111"
                        ),
                        array(
                            "name"=> "乌当区",
                            "code"=> "520112"
                        ),
                        array(
                            "name"=> "白云区",
                            "code"=> "520113"
                        ),
                        array(
                            "name"=> "观山湖区",
                            "code"=> "520115"
                        ),
                        array(
                            "name"=> "开阳县",
                            "code"=> "520121"
                        ),
                        array(
                            "name"=> "息烽县",
                            "code"=> "520122"
                        ),
                        array(
                            "name"=> "修文县",
                            "code"=> "520123"
                        ),
                        array(
                            "name"=> "清镇市",
                            "code"=> "520181"
                        )
                    ]
                ),
                array(
                    "name"=> "六盘水市",
                    "code"=> "520200",
                    "sub"=> [
                        array(
                            "name"=> "钟山区",
                            "code"=> "520201"
                        ),
                        array(
                            "name"=> "六枝特区",
                            "code"=> "520203"
                        ),
                        array(
                            "name"=> "水城县",
                            "code"=> "520221"
                        ),
                        array(
                            "name"=> "盘县",
                            "code"=> "520222"
                        )
                    ]
                ),
                array(
                    "name"=> "遵义市",
                    "code"=> "520300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "520301"
                        ),
                        array(
                            "name"=> "红花岗区",
                            "code"=> "520302"
                        ),
                        array(
                            "name"=> "汇川区",
                            "code"=> "520303"
                        ),
                        array(
                            "name"=> "遵义县",
                            "code"=> "520321"
                        ),
                        array(
                            "name"=> "桐梓县",
                            "code"=> "520322"
                        ),
                        array(
                            "name"=> "绥阳县",
                            "code"=> "520323"
                        ),
                        array(
                            "name"=> "正安县",
                            "code"=> "520324"
                        ),
                        array(
                            "name"=> "道真仡佬族苗族自治县",
                            "code"=> "520325"
                        ),
                        array(
                            "name"=> "务川仡佬族苗族自治县",
                            "code"=> "520326"
                        ),
                        array(
                            "name"=> "凤冈县",
                            "code"=> "520327"
                        ),
                        array(
                            "name"=> "湄潭县",
                            "code"=> "520328"
                        ),
                        array(
                            "name"=> "余庆县",
                            "code"=> "520329"
                        ),
                        array(
                            "name"=> "习水县",
                            "code"=> "520330"
                        ),
                        array(
                            "name"=> "赤水市",
                            "code"=> "520381"
                        ),
                        array(
                            "name"=> "仁怀市",
                            "code"=> "520382"
                        )
                    ]
                ),
                array(
                    "name"=> "安顺市",
                    "code"=> "520400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "520401"
                        ),
                        array(
                            "name"=> "西秀区",
                            "code"=> "520402"
                        ),
                        array(
                            "name"=> "平坝区",
                            "code"=> "520403"
                        ),
                        array(
                            "name"=> "普定县",
                            "code"=> "520422"
                        ),
                        array(
                            "name"=> "镇宁布依族苗族自治县",
                            "code"=> "520423"
                        ),
                        array(
                            "name"=> "关岭布依族苗族自治县",
                            "code"=> "520424"
                        ),
                        array(
                            "name"=> "紫云苗族布依族自治县",
                            "code"=> "520425"
                        )
                    ]
                ),
                array(
                    "name"=> "毕节市",
                    "code"=> "520500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "520501"
                        ),
                        array(
                            "name"=> "七星关区",
                            "code"=> "520502"
                        ),
                        array(
                            "name"=> "大方县",
                            "code"=> "520521"
                        ),
                        array(
                            "name"=> "黔西县",
                            "code"=> "520522"
                        ),
                        array(
                            "name"=> "金沙县",
                            "code"=> "520523"
                        ),
                        array(
                            "name"=> "织金县",
                            "code"=> "520524"
                        ),
                        array(
                            "name"=> "纳雍县",
                            "code"=> "520525"
                        ),
                        array(
                            "name"=> "威宁彝族回族苗族自治县",
                            "code"=> "520526"
                        ),
                        array(
                            "name"=> "赫章县",
                            "code"=> "520527"
                        )
                    ]
                ),
                array(
                    "name"=> "铜仁市",
                    "code"=> "520600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "520601"
                        ),
                        array(
                            "name"=> "碧江区",
                            "code"=> "520602"
                        ),
                        array(
                            "name"=> "万山区",
                            "code"=> "520603"
                        ),
                        array(
                            "name"=> "江口县",
                            "code"=> "520621"
                        ),
                        array(
                            "name"=> "玉屏侗族自治县",
                            "code"=> "520622"
                        ),
                        array(
                            "name"=> "石阡县",
                            "code"=> "520623"
                        ),
                        array(
                            "name"=> "思南县",
                            "code"=> "520624"
                        ),
                        array(
                            "name"=> "印江土家族苗族自治县",
                            "code"=> "520625"
                        ),
                        array(
                            "name"=> "德江县",
                            "code"=> "520626"
                        ),
                        array(
                            "name"=> "沿河土家族自治县",
                            "code"=> "520627"
                        ),
                        array(
                            "name"=> "松桃苗族自治县",
                            "code"=> "520628"
                        )
                    ]
                ),
                array(
                    "name"=> "黔西南布依族苗族自治州",
                    "code"=> "522300",
                    "sub"=> [
                        array(
                            "name"=> "兴义市",
                            "code"=> "522301"
                        ),
                        array(
                            "name"=> "兴仁县",
                            "code"=> "522322"
                        ),
                        array(
                            "name"=> "普安县",
                            "code"=> "522323"
                        ),
                        array(
                            "name"=> "晴隆县",
                            "code"=> "522324"
                        ),
                        array(
                            "name"=> "贞丰县",
                            "code"=> "522325"
                        ),
                        array(
                            "name"=> "望谟县",
                            "code"=> "522326"
                        ),
                        array(
                            "name"=> "册亨县",
                            "code"=> "522327"
                        ),
                        array(
                            "name"=> "安龙县",
                            "code"=> "522328"
                        )
                    ]
                ),
                array(
                    "name"=> "黔东南苗族侗族自治州",
                    "code"=> "522600",
                    "sub"=> [
                        array(
                            "name"=> "凯里市",
                            "code"=> "522601"
                        ),
                        array(
                            "name"=> "黄平县",
                            "code"=> "522622"
                        ),
                        array(
                            "name"=> "施秉县",
                            "code"=> "522623"
                        ),
                        array(
                            "name"=> "三穗县",
                            "code"=> "522624"
                        ),
                        array(
                            "name"=> "镇远县",
                            "code"=> "522625"
                        ),
                        array(
                            "name"=> "岑巩县",
                            "code"=> "522626"
                        ),
                        array(
                            "name"=> "天柱县",
                            "code"=> "522627"
                        ),
                        array(
                            "name"=> "锦屏县",
                            "code"=> "522628"
                        ),
                        array(
                            "name"=> "剑河县",
                            "code"=> "522629"
                        ),
                        array(
                            "name"=> "台江县",
                            "code"=> "522630"
                        ),
                        array(
                            "name"=> "黎平县",
                            "code"=> "522631"
                        ),
                        array(
                            "name"=> "榕江县",
                            "code"=> "522632"
                        ),
                        array(
                            "name"=> "从江县",
                            "code"=> "522633"
                        ),
                        array(
                            "name"=> "雷山县",
                            "code"=> "522634"
                        ),
                        array(
                            "name"=> "麻江县",
                            "code"=> "522635"
                        ),
                        array(
                            "name"=> "丹寨县",
                            "code"=> "522636"
                        )
                    ]
                ),
                array(
                    "name"=> "黔南布依族苗族自治州",
                    "code"=> "522700",
                    "sub"=> [
                        array(
                            "name"=> "都匀市",
                            "code"=> "522701"
                        ),
                        array(
                            "name"=> "福泉市",
                            "code"=> "522702"
                        ),
                        array(
                            "name"=> "荔波县",
                            "code"=> "522722"
                        ),
                        array(
                            "name"=> "贵定县",
                            "code"=> "522723"
                        ),
                        array(
                            "name"=> "瓮安县",
                            "code"=> "522725"
                        ),
                        array(
                            "name"=> "独山县",
                            "code"=> "522726"
                        ),
                        array(
                            "name"=> "平塘县",
                            "code"=> "522727"
                        ),
                        array(
                            "name"=> "罗甸县",
                            "code"=> "522728"
                        ),
                        array(
                            "name"=> "长顺县",
                            "code"=> "522729"
                        ),
                        array(
                            "name"=> "龙里县",
                            "code"=> "522730"
                        ),
                        array(
                            "name"=> "惠水县",
                            "code"=> "522731"
                        ),
                        array(
                            "name"=> "三都水族自治县",
                            "code"=> "522732"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "云南省",
            "code"=> "530000",
            "sub"=> [
                array(
                    "name"=> "昆明市",
                    "code"=> "530100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530101"
                        ),
                        array(
                            "name"=> "五华区",
                            "code"=> "530102"
                        ),
                        array(
                            "name"=> "盘龙区",
                            "code"=> "530103"
                        ),
                        array(
                            "name"=> "官渡区",
                            "code"=> "530111"
                        ),
                        array(
                            "name"=> "西山区",
                            "code"=> "530112"
                        ),
                        array(
                            "name"=> "东川区",
                            "code"=> "530113"
                        ),
                        array(
                            "name"=> "呈贡区",
                            "code"=> "530114"
                        ),
                        array(
                            "name"=> "晋宁县",
                            "code"=> "530122"
                        ),
                        array(
                            "name"=> "富民县",
                            "code"=> "530124"
                        ),
                        array(
                            "name"=> "宜良县",
                            "code"=> "530125"
                        ),
                        array(
                            "name"=> "石林彝族自治县",
                            "code"=> "530126"
                        ),
                        array(
                            "name"=> "嵩明县",
                            "code"=> "530127"
                        ),
                        array(
                            "name"=> "禄劝彝族苗族自治县",
                            "code"=> "530128"
                        ),
                        array(
                            "name"=> "寻甸回族彝族自治县",
                            "code"=> "530129"
                        ),
                        array(
                            "name"=> "安宁市",
                            "code"=> "530181"
                        )
                    ]
                ),
                array(
                    "name"=> "曲靖市",
                    "code"=> "530300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530301"
                        ),
                        array(
                            "name"=> "麒麟区",
                            "code"=> "530302"
                        ),
                        array(
                            "name"=> "马龙县",
                            "code"=> "530321"
                        ),
                        array(
                            "name"=> "陆良县",
                            "code"=> "530322"
                        ),
                        array(
                            "name"=> "师宗县",
                            "code"=> "530323"
                        ),
                        array(
                            "name"=> "罗平县",
                            "code"=> "530324"
                        ),
                        array(
                            "name"=> "富源县",
                            "code"=> "530325"
                        ),
                        array(
                            "name"=> "会泽县",
                            "code"=> "530326"
                        ),
                        array(
                            "name"=> "沾益县",
                            "code"=> "530328"
                        ),
                        array(
                            "name"=> "宣威市",
                            "code"=> "530381"
                        )
                    ]
                ),
                array(
                    "name"=> "玉溪市",
                    "code"=> "530400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530401"
                        ),
                        array(
                            "name"=> "红塔区",
                            "code"=> "530402"
                        ),
                        array(
                            "name"=> "江川县",
                            "code"=> "530421"
                        ),
                        array(
                            "name"=> "澄江县",
                            "code"=> "530422"
                        ),
                        array(
                            "name"=> "通海县",
                            "code"=> "530423"
                        ),
                        array(
                            "name"=> "华宁县",
                            "code"=> "530424"
                        ),
                        array(
                            "name"=> "易门县",
                            "code"=> "530425"
                        ),
                        array(
                            "name"=> "峨山彝族自治县",
                            "code"=> "530426"
                        ),
                        array(
                            "name"=> "新平彝族傣族自治县",
                            "code"=> "530427"
                        ),
                        array(
                            "name"=> "元江哈尼族彝族傣族自治县",
                            "code"=> "530428"
                        )
                    ]
                ),
                array(
                    "name"=> "保山市",
                    "code"=> "530500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530501"
                        ),
                        array(
                            "name"=> "隆阳区",
                            "code"=> "530502"
                        ),
                        array(
                            "name"=> "施甸县",
                            "code"=> "530521"
                        ),
                        array(
                            "name"=> "腾冲县",
                            "code"=> "530522"
                        ),
                        array(
                            "name"=> "龙陵县",
                            "code"=> "530523"
                        ),
                        array(
                            "name"=> "昌宁县",
                            "code"=> "530524"
                        )
                    ]
                ),
                array(
                    "name"=> "昭通市",
                    "code"=> "530600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530601"
                        ),
                        array(
                            "name"=> "昭阳区",
                            "code"=> "530602"
                        ),
                        array(
                            "name"=> "鲁甸县",
                            "code"=> "530621"
                        ),
                        array(
                            "name"=> "巧家县",
                            "code"=> "530622"
                        ),
                        array(
                            "name"=> "盐津县",
                            "code"=> "530623"
                        ),
                        array(
                            "name"=> "大关县",
                            "code"=> "530624"
                        ),
                        array(
                            "name"=> "永善县",
                            "code"=> "530625"
                        ),
                        array(
                            "name"=> "绥江县",
                            "code"=> "530626"
                        ),
                        array(
                            "name"=> "镇雄县",
                            "code"=> "530627"
                        ),
                        array(
                            "name"=> "彝良县",
                            "code"=> "530628"
                        ),
                        array(
                            "name"=> "威信县",
                            "code"=> "530629"
                        ),
                        array(
                            "name"=> "水富县",
                            "code"=> "530630"
                        )
                    ]
                ),
                array(
                    "name"=> "丽江市",
                    "code"=> "530700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530701"
                        ),
                        array(
                            "name"=> "古城区",
                            "code"=> "530702"
                        ),
                        array(
                            "name"=> "玉龙纳西族自治县",
                            "code"=> "530721"
                        ),
                        array(
                            "name"=> "永胜县",
                            "code"=> "530722"
                        ),
                        array(
                            "name"=> "华坪县",
                            "code"=> "530723"
                        ),
                        array(
                            "name"=> "宁蒗彝族自治县",
                            "code"=> "530724"
                        )
                    ]
                ),
                array(
                    "name"=> "普洱市",
                    "code"=> "530800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530801"
                        ),
                        array(
                            "name"=> "思茅区",
                            "code"=> "530802"
                        ),
                        array(
                            "name"=> "宁洱哈尼族彝族自治县",
                            "code"=> "530821"
                        ),
                        array(
                            "name"=> "墨江哈尼族自治县",
                            "code"=> "530822"
                        ),
                        array(
                            "name"=> "景东彝族自治县",
                            "code"=> "530823"
                        ),
                        array(
                            "name"=> "景谷傣族彝族自治县",
                            "code"=> "530824"
                        ),
                        array(
                            "name"=> "镇沅彝族哈尼族拉祜族自治县",
                            "code"=> "530825"
                        ),
                        array(
                            "name"=> "江城哈尼族彝族自治县",
                            "code"=> "530826"
                        ),
                        array(
                            "name"=> "孟连傣族拉祜族佤族自治县",
                            "code"=> "530827"
                        ),
                        array(
                            "name"=> "澜沧拉祜族自治县",
                            "code"=> "530828"
                        ),
                        array(
                            "name"=> "西盟佤族自治县",
                            "code"=> "530829"
                        )
                    ]
                ),
                array(
                    "name"=> "临沧市",
                    "code"=> "530900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "530901"
                        ),
                        array(
                            "name"=> "临翔区",
                            "code"=> "530902"
                        ),
                        array(
                            "name"=> "凤庆县",
                            "code"=> "530921"
                        ),
                        array(
                            "name"=> "云县",
                            "code"=> "530922"
                        ),
                        array(
                            "name"=> "永德县",
                            "code"=> "530923"
                        ),
                        array(
                            "name"=> "镇康县",
                            "code"=> "530924"
                        ),
                        array(
                            "name"=> "双江拉祜族佤族布朗族傣族自治县",
                            "code"=> "530925"
                        ),
                        array(
                            "name"=> "耿马傣族佤族自治县",
                            "code"=> "530926"
                        ),
                        array(
                            "name"=> "沧源佤族自治县",
                            "code"=> "530927"
                        )
                    ]
                ),
                array(
                    "name"=> "楚雄彝族自治州",
                    "code"=> "532300",
                    "sub"=> [
                        array(
                            "name"=> "楚雄市",
                            "code"=> "532301"
                        ),
                        array(
                            "name"=> "双柏县",
                            "code"=> "532322"
                        ),
                        array(
                            "name"=> "牟定县",
                            "code"=> "532323"
                        ),
                        array(
                            "name"=> "南华县",
                            "code"=> "532324"
                        ),
                        array(
                            "name"=> "姚安县",
                            "code"=> "532325"
                        ),
                        array(
                            "name"=> "大姚县",
                            "code"=> "532326"
                        ),
                        array(
                            "name"=> "永仁县",
                            "code"=> "532327"
                        ),
                        array(
                            "name"=> "元谋县",
                            "code"=> "532328"
                        ),
                        array(
                            "name"=> "武定县",
                            "code"=> "532329"
                        ),
                        array(
                            "name"=> "禄丰县",
                            "code"=> "532331"
                        )
                    ]
                ),
                array(
                    "name"=> "红河哈尼族彝族自治州",
                    "code"=> "532500",
                    "sub"=> [
                        array(
                            "name"=> "个旧市",
                            "code"=> "532501"
                        ),
                        array(
                            "name"=> "开远市",
                            "code"=> "532502"
                        ),
                        array(
                            "name"=> "蒙自市",
                            "code"=> "532503"
                        ),
                        array(
                            "name"=> "弥勒市",
                            "code"=> "532504"
                        ),
                        array(
                            "name"=> "屏边苗族自治县",
                            "code"=> "532523"
                        ),
                        array(
                            "name"=> "建水县",
                            "code"=> "532524"
                        ),
                        array(
                            "name"=> "石屏县",
                            "code"=> "532525"
                        ),
                        array(
                            "name"=> "泸西县",
                            "code"=> "532527"
                        ),
                        array(
                            "name"=> "元阳县",
                            "code"=> "532528"
                        ),
                        array(
                            "name"=> "红河县",
                            "code"=> "532529"
                        ),
                        array(
                            "name"=> "金平苗族瑶族傣族自治县",
                            "code"=> "532530"
                        ),
                        array(
                            "name"=> "绿春县",
                            "code"=> "532531"
                        ),
                        array(
                            "name"=> "河口瑶族自治县",
                            "code"=> "532532"
                        )
                    ]
                ),
                array(
                    "name"=> "文山壮族苗族自治州",
                    "code"=> "532600",
                    "sub"=> [
                        array(
                            "name"=> "文山市",
                            "code"=> "532601"
                        ),
                        array(
                            "name"=> "砚山县",
                            "code"=> "532622"
                        ),
                        array(
                            "name"=> "西畴县",
                            "code"=> "532623"
                        ),
                        array(
                            "name"=> "麻栗坡县",
                            "code"=> "532624"
                        ),
                        array(
                            "name"=> "马关县",
                            "code"=> "532625"
                        ),
                        array(
                            "name"=> "丘北县",
                            "code"=> "532626"
                        ),
                        array(
                            "name"=> "广南县",
                            "code"=> "532627"
                        ),
                        array(
                            "name"=> "富宁县",
                            "code"=> "532628"
                        )
                    ]
                ),
                array(
                    "name"=> "西双版纳傣族自治州",
                    "code"=> "532800",
                    "sub"=> [
                        array(
                            "name"=> "景洪市",
                            "code"=> "532801"
                        ),
                        array(
                            "name"=> "勐海县",
                            "code"=> "532822"
                        ),
                        array(
                            "name"=> "勐腊县",
                            "code"=> "532823"
                        )
                    ]
                ),
                array(
                    "name"=> "大理白族自治州",
                    "code"=> "532900",
                    "sub"=> [
                        array(
                            "name"=> "大理市",
                            "code"=> "532901"
                        ),
                        array(
                            "name"=> "漾濞彝族自治县",
                            "code"=> "532922"
                        ),
                        array(
                            "name"=> "祥云县",
                            "code"=> "532923"
                        ),
                        array(
                            "name"=> "宾川县",
                            "code"=> "532924"
                        ),
                        array(
                            "name"=> "弥渡县",
                            "code"=> "532925"
                        ),
                        array(
                            "name"=> "南涧彝族自治县",
                            "code"=> "532926"
                        ),
                        array(
                            "name"=> "巍山彝族回族自治县",
                            "code"=> "532927"
                        ),
                        array(
                            "name"=> "永平县",
                            "code"=> "532928"
                        ),
                        array(
                            "name"=> "云龙县",
                            "code"=> "532929"
                        ),
                        array(
                            "name"=> "洱源县",
                            "code"=> "532930"
                        ),
                        array(
                            "name"=> "剑川县",
                            "code"=> "532931"
                        ),
                        array(
                            "name"=> "鹤庆县",
                            "code"=> "532932"
                        )
                    ]
                ),
                array(
                    "name"=> "德宏傣族景颇族自治州",
                    "code"=> "533100",
                    "sub"=> [
                        array(
                            "name"=> "瑞丽市",
                            "code"=> "533102"
                        ),
                        array(
                            "name"=> "芒市",
                            "code"=> "533103"
                        ),
                        array(
                            "name"=> "梁河县",
                            "code"=> "533122"
                        ),
                        array(
                            "name"=> "盈江县",
                            "code"=> "533123"
                        ),
                        array(
                            "name"=> "陇川县",
                            "code"=> "533124"
                        )
                    ]
                ),
                array(
                    "name"=> "怒江傈僳族自治州",
                    "code"=> "533300",
                    "sub"=> [
                        array(
                            "name"=> "泸水县",
                            "code"=> "533321"
                        ),
                        array(
                            "name"=> "福贡县",
                            "code"=> "533323"
                        ),
                        array(
                            "name"=> "贡山独龙族怒族自治县",
                            "code"=> "533324"
                        ),
                        array(
                            "name"=> "兰坪白族普米族自治县",
                            "code"=> "533325"
                        )
                    ]
                ),
                array(
                    "name"=> "迪庆藏族自治州",
                    "code"=> "533400",
                    "sub"=> [
                        array(
                            "name"=> "香格里拉市",
                            "code"=> "533401"
                        ),
                        array(
                            "name"=> "德钦县",
                            "code"=> "533422"
                        ),
                        array(
                            "name"=> "维西傈僳族自治县",
                            "code"=> "533423"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "西藏自治区",
            "code"=> "540000",
            "sub"=> [
                array(
                    "name"=> "拉萨市",
                    "code"=> "540100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "540101"
                        ),
                        array(
                            "name"=> "城关区",
                            "code"=> "540102"
                        ),
                        array(
                            "name"=> "林周县",
                            "code"=> "540121"
                        ),
                        array(
                            "name"=> "当雄县",
                            "code"=> "540122"
                        ),
                        array(
                            "name"=> "尼木县",
                            "code"=> "540123"
                        ),
                        array(
                            "name"=> "曲水县",
                            "code"=> "540124"
                        ),
                        array(
                            "name"=> "堆龙德庆县",
                            "code"=> "540125"
                        ),
                        array(
                            "name"=> "达孜县",
                            "code"=> "540126"
                        ),
                        array(
                            "name"=> "墨竹工卡县",
                            "code"=> "540127"
                        )
                    ]
                ),
                array(
                    "name"=> "日喀则市",
                    "code"=> "540200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "540201"
                        ),
                        array(
                            "name"=> "桑珠孜区",
                            "code"=> "540202"
                        ),
                        array(
                            "name"=> "南木林县",
                            "code"=> "540221"
                        ),
                        array(
                            "name"=> "江孜县",
                            "code"=> "540222"
                        ),
                        array(
                            "name"=> "定日县",
                            "code"=> "540223"
                        ),
                        array(
                            "name"=> "萨迦县",
                            "code"=> "540224"
                        ),
                        array(
                            "name"=> "拉孜县",
                            "code"=> "540225"
                        ),
                        array(
                            "name"=> "昂仁县",
                            "code"=> "540226"
                        ),
                        array(
                            "name"=> "谢通门县",
                            "code"=> "540227"
                        ),
                        array(
                            "name"=> "白朗县",
                            "code"=> "540228"
                        ),
                        array(
                            "name"=> "仁布县",
                            "code"=> "540229"
                        ),
                        array(
                            "name"=> "康马县",
                            "code"=> "540230"
                        ),
                        array(
                            "name"=> "定结县",
                            "code"=> "540231"
                        ),
                        array(
                            "name"=> "仲巴县",
                            "code"=> "540232"
                        ),
                        array(
                            "name"=> "亚东县",
                            "code"=> "540233"
                        ),
                        array(
                            "name"=> "吉隆县",
                            "code"=> "540234"
                        ),
                        array(
                            "name"=> "聂拉木县",
                            "code"=> "540235"
                        ),
                        array(
                            "name"=> "萨嘎县",
                            "code"=> "540236"
                        ),
                        array(
                            "name"=> "岗巴县",
                            "code"=> "540237"
                        )
                    ]
                ),
                array(
                    "name"=> "昌都市",
                    "code"=> "540300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "540301"
                        ),
                        array(
                            "name"=> "卡若区",
                            "code"=> "540302"
                        ),
                        array(
                            "name"=> "江达县",
                            "code"=> "540321"
                        ),
                        array(
                            "name"=> "贡觉县",
                            "code"=> "540322"
                        ),
                        array(
                            "name"=> "类乌齐县",
                            "code"=> "540323"
                        ),
                        array(
                            "name"=> "丁青县",
                            "code"=> "540324"
                        ),
                        array(
                            "name"=> "察雅县",
                            "code"=> "540325"
                        ),
                        array(
                            "name"=> "八宿县",
                            "code"=> "540326"
                        ),
                        array(
                            "name"=> "左贡县",
                            "code"=> "540327"
                        ),
                        array(
                            "name"=> "芒康县",
                            "code"=> "540328"
                        ),
                        array(
                            "name"=> "洛隆县",
                            "code"=> "540329"
                        ),
                        array(
                            "name"=> "边坝县",
                            "code"=> "540330"
                        )
                    ]
                ),
                array(
                    "name"=> "山南地区",
                    "code"=> "542200",
                    "sub"=> [
                        array(
                            "name"=> "乃东县",
                            "code"=> "542221"
                        ),
                        array(
                            "name"=> "扎囊县",
                            "code"=> "542222"
                        ),
                        array(
                            "name"=> "贡嘎县",
                            "code"=> "542223"
                        ),
                        array(
                            "name"=> "桑日县",
                            "code"=> "542224"
                        ),
                        array(
                            "name"=> "琼结县",
                            "code"=> "542225"
                        ),
                        array(
                            "name"=> "曲松县",
                            "code"=> "542226"
                        ),
                        array(
                            "name"=> "措美县",
                            "code"=> "542227"
                        ),
                        array(
                            "name"=> "洛扎县",
                            "code"=> "542228"
                        ),
                        array(
                            "name"=> "加查县",
                            "code"=> "542229"
                        ),
                        array(
                            "name"=> "隆子县",
                            "code"=> "542231"
                        ),
                        array(
                            "name"=> "错那县",
                            "code"=> "542232"
                        ),
                        array(
                            "name"=> "浪卡子县",
                            "code"=> "542233"
                        )
                    ]
                ),
                array(
                    "name"=> "那曲地区",
                    "code"=> "542400",
                    "sub"=> [
                        array(
                            "name"=> "那曲县",
                            "code"=> "542421"
                        ),
                        array(
                            "name"=> "嘉黎县",
                            "code"=> "542422"
                        ),
                        array(
                            "name"=> "比如县",
                            "code"=> "542423"
                        ),
                        array(
                            "name"=> "聂荣县",
                            "code"=> "542424"
                        ),
                        array(
                            "name"=> "安多县",
                            "code"=> "542425"
                        ),
                        array(
                            "name"=> "申扎县",
                            "code"=> "542426"
                        ),
                        array(
                            "name"=> "索县",
                            "code"=> "542427"
                        ),
                        array(
                            "name"=> "班戈县",
                            "code"=> "542428"
                        ),
                        array(
                            "name"=> "巴青县",
                            "code"=> "542429"
                        ),
                        array(
                            "name"=> "尼玛县",
                            "code"=> "542430"
                        ),
                        array(
                            "name"=> "双湖县",
                            "code"=> "542431"
                        )
                    ]
                ),
                array(
                    "name"=> "阿里地区",
                    "code"=> "542500",
                    "sub"=> [
                        array(
                            "name"=> "普兰县",
                            "code"=> "542521"
                        ),
                        array(
                            "name"=> "札达县",
                            "code"=> "542522"
                        ),
                        array(
                            "name"=> "噶尔县",
                            "code"=> "542523"
                        ),
                        array(
                            "name"=> "日土县",
                            "code"=> "542524"
                        ),
                        array(
                            "name"=> "革吉县",
                            "code"=> "542525"
                        ),
                        array(
                            "name"=> "改则县",
                            "code"=> "542526"
                        ),
                        array(
                            "name"=> "措勤县",
                            "code"=> "542527"
                        )
                    ]
                ),
                array(
                    "name"=> "林芝地区",
                    "code"=> "542600",
                    "sub"=> [
                        array(
                            "name"=> "林芝县",
                            "code"=> "542621"
                        ),
                        array(
                            "name"=> "工布江达县",
                            "code"=> "542622"
                        ),
                        array(
                            "name"=> "米林县",
                            "code"=> "542623"
                        ),
                        array(
                            "name"=> "墨脱县",
                            "code"=> "542624"
                        ),
                        array(
                            "name"=> "波密县",
                            "code"=> "542625"
                        ),
                        array(
                            "name"=> "察隅县",
                            "code"=> "542626"
                        ),
                        array(
                            "name"=> "朗县",
                            "code"=> "542627"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "陕西省",
            "code"=> "610000",
            "sub"=> [
                array(
                    "name"=> "西安市",
                    "code"=> "610100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610101"
                        ),
                        array(
                            "name"=> "新城区",
                            "code"=> "610102"
                        ),
                        array(
                            "name"=> "碑林区",
                            "code"=> "610103"
                        ),
                        array(
                            "name"=> "莲湖区",
                            "code"=> "610104"
                        ),
                        array(
                            "name"=> "灞桥区",
                            "code"=> "610111"
                        ),
                        array(
                            "name"=> "未央区",
                            "code"=> "610112"
                        ),
                        array(
                            "name"=> "雁塔区",
                            "code"=> "610113"
                        ),
                        array(
                            "name"=> "阎良区",
                            "code"=> "610114"
                        ),
                        array(
                            "name"=> "临潼区",
                            "code"=> "610115"
                        ),
                        array(
                            "name"=> "长安区",
                            "code"=> "610116"
                        ),
                        array(
                            "name"=> "高陵区",
                            "code"=> "610117"
                        ),
                        array(
                            "name"=> "蓝田县",
                            "code"=> "610122"
                        ),
                        array(
                            "name"=> "周至县",
                            "code"=> "610124"
                        ),
                        array(
                            "name"=> "户县",
                            "code"=> "610125"
                        )
                    ]
                ),
                array(
                    "name"=> "铜川市",
                    "code"=> "610200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610201"
                        ),
                        array(
                            "name"=> "王益区",
                            "code"=> "610202"
                        ),
                        array(
                            "name"=> "印台区",
                            "code"=> "610203"
                        ),
                        array(
                            "name"=> "耀州区",
                            "code"=> "610204"
                        ),
                        array(
                            "name"=> "宜君县",
                            "code"=> "610222"
                        )
                    ]
                ),
                array(
                    "name"=> "宝鸡市",
                    "code"=> "610300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610301"
                        ),
                        array(
                            "name"=> "渭滨区",
                            "code"=> "610302"
                        ),
                        array(
                            "name"=> "金台区",
                            "code"=> "610303"
                        ),
                        array(
                            "name"=> "陈仓区",
                            "code"=> "610304"
                        ),
                        array(
                            "name"=> "凤翔县",
                            "code"=> "610322"
                        ),
                        array(
                            "name"=> "岐山县",
                            "code"=> "610323"
                        ),
                        array(
                            "name"=> "扶风县",
                            "code"=> "610324"
                        ),
                        array(
                            "name"=> "眉县",
                            "code"=> "610326"
                        ),
                        array(
                            "name"=> "陇县",
                            "code"=> "610327"
                        ),
                        array(
                            "name"=> "千阳县",
                            "code"=> "610328"
                        ),
                        array(
                            "name"=> "麟游县",
                            "code"=> "610329"
                        ),
                        array(
                            "name"=> "凤县",
                            "code"=> "610330"
                        ),
                        array(
                            "name"=> "太白县",
                            "code"=> "610331"
                        )
                    ]
                ),
                array(
                    "name"=> "咸阳市",
                    "code"=> "610400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610401"
                        ),
                        array(
                            "name"=> "秦都区",
                            "code"=> "610402"
                        ),
                        array(
                            "name"=> "杨陵区",
                            "code"=> "610403"
                        ),
                        array(
                            "name"=> "渭城区",
                            "code"=> "610404"
                        ),
                        array(
                            "name"=> "三原县",
                            "code"=> "610422"
                        ),
                        array(
                            "name"=> "泾阳县",
                            "code"=> "610423"
                        ),
                        array(
                            "name"=> "乾县",
                            "code"=> "610424"
                        ),
                        array(
                            "name"=> "礼泉县",
                            "code"=> "610425"
                        ),
                        array(
                            "name"=> "永寿县",
                            "code"=> "610426"
                        ),
                        array(
                            "name"=> "彬县",
                            "code"=> "610427"
                        ),
                        array(
                            "name"=> "长武县",
                            "code"=> "610428"
                        ),
                        array(
                            "name"=> "旬邑县",
                            "code"=> "610429"
                        ),
                        array(
                            "name"=> "淳化县",
                            "code"=> "610430"
                        ),
                        array(
                            "name"=> "武功县",
                            "code"=> "610431"
                        ),
                        array(
                            "name"=> "兴平市",
                            "code"=> "610481"
                        )
                    ]
                ),
                array(
                    "name"=> "渭南市",
                    "code"=> "610500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610501"
                        ),
                        array(
                            "name"=> "临渭区",
                            "code"=> "610502"
                        ),
                        array(
                            "name"=> "华县",
                            "code"=> "610521"
                        ),
                        array(
                            "name"=> "潼关县",
                            "code"=> "610522"
                        ),
                        array(
                            "name"=> "大荔县",
                            "code"=> "610523"
                        ),
                        array(
                            "name"=> "合阳县",
                            "code"=> "610524"
                        ),
                        array(
                            "name"=> "澄城县",
                            "code"=> "610525"
                        ),
                        array(
                            "name"=> "蒲城县",
                            "code"=> "610526"
                        ),
                        array(
                            "name"=> "白水县",
                            "code"=> "610527"
                        ),
                        array(
                            "name"=> "富平县",
                            "code"=> "610528"
                        ),
                        array(
                            "name"=> "韩城市",
                            "code"=> "610581"
                        ),
                        array(
                            "name"=> "华阴市",
                            "code"=> "610582"
                        )
                    ]
                ),
                array(
                    "name"=> "延安市",
                    "code"=> "610600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610601"
                        ),
                        array(
                            "name"=> "宝塔区",
                            "code"=> "610602"
                        ),
                        array(
                            "name"=> "延长县",
                            "code"=> "610621"
                        ),
                        array(
                            "name"=> "延川县",
                            "code"=> "610622"
                        ),
                        array(
                            "name"=> "子长县",
                            "code"=> "610623"
                        ),
                        array(
                            "name"=> "安塞县",
                            "code"=> "610624"
                        ),
                        array(
                            "name"=> "志丹县",
                            "code"=> "610625"
                        ),
                        array(
                            "name"=> "吴起县",
                            "code"=> "610626"
                        ),
                        array(
                            "name"=> "甘泉县",
                            "code"=> "610627"
                        ),
                        array(
                            "name"=> "富县",
                            "code"=> "610628"
                        ),
                        array(
                            "name"=> "洛川县",
                            "code"=> "610629"
                        ),
                        array(
                            "name"=> "宜川县",
                            "code"=> "610630"
                        ),
                        array(
                            "name"=> "黄龙县",
                            "code"=> "610631"
                        ),
                        array(
                            "name"=> "黄陵县",
                            "code"=> "610632"
                        )
                    ]
                ),
                array(
                    "name"=> "汉中市",
                    "code"=> "610700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610701"
                        ),
                        array(
                            "name"=> "汉台区",
                            "code"=> "610702"
                        ),
                        array(
                            "name"=> "南郑县",
                            "code"=> "610721"
                        ),
                        array(
                            "name"=> "城固县",
                            "code"=> "610722"
                        ),
                        array(
                            "name"=> "洋县",
                            "code"=> "610723"
                        ),
                        array(
                            "name"=> "西乡县",
                            "code"=> "610724"
                        ),
                        array(
                            "name"=> "勉县",
                            "code"=> "610725"
                        ),
                        array(
                            "name"=> "宁强县",
                            "code"=> "610726"
                        ),
                        array(
                            "name"=> "略阳县",
                            "code"=> "610727"
                        ),
                        array(
                            "name"=> "镇巴县",
                            "code"=> "610728"
                        ),
                        array(
                            "name"=> "留坝县",
                            "code"=> "610729"
                        ),
                        array(
                            "name"=> "佛坪县",
                            "code"=> "610730"
                        )
                    ]
                ),
                array(
                    "name"=> "榆林市",
                    "code"=> "610800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610801"
                        ),
                        array(
                            "name"=> "榆阳区",
                            "code"=> "610802"
                        ),
                        array(
                            "name"=> "神木县",
                            "code"=> "610821"
                        ),
                        array(
                            "name"=> "府谷县",
                            "code"=> "610822"
                        ),
                        array(
                            "name"=> "横山县",
                            "code"=> "610823"
                        ),
                        array(
                            "name"=> "靖边县",
                            "code"=> "610824"
                        ),
                        array(
                            "name"=> "定边县",
                            "code"=> "610825"
                        ),
                        array(
                            "name"=> "绥德县",
                            "code"=> "610826"
                        ),
                        array(
                            "name"=> "米脂县",
                            "code"=> "610827"
                        ),
                        array(
                            "name"=> "佳县",
                            "code"=> "610828"
                        ),
                        array(
                            "name"=> "吴堡县",
                            "code"=> "610829"
                        ),
                        array(
                            "name"=> "清涧县",
                            "code"=> "610830"
                        ),
                        array(
                            "name"=> "子洲县",
                            "code"=> "610831"
                        )
                    ]
                ),
                array(
                    "name"=> "安康市",
                    "code"=> "610900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "610901"
                        ),
                        array(
                            "name"=> "汉阴县",
                            "code"=> "610921"
                        ),
                        array(
                            "name"=> "石泉县",
                            "code"=> "610922"
                        ),
                        array(
                            "name"=> "宁陕县",
                            "code"=> "610923"
                        ),
                        array(
                            "name"=> "紫阳县",
                            "code"=> "610924"
                        ),
                        array(
                            "name"=> "岚皋县",
                            "code"=> "610925"
                        ),
                        array(
                            "name"=> "平利县",
                            "code"=> "610926"
                        ),
                        array(
                            "name"=> "镇坪县",
                            "code"=> "610927"
                        ),
                        array(
                            "name"=> "旬阳县",
                            "code"=> "610928"
                        ),
                        array(
                            "name"=> "白河县",
                            "code"=> "610929"
                        )
                    ]
                ),
                array(
                    "name"=> "商洛市",
                    "code"=> "611000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "611001"
                        ),
                        array(
                            "name"=> "商州区",
                            "code"=> "611002"
                        ),
                        array(
                            "name"=> "洛南县",
                            "code"=> "611021"
                        ),
                        array(
                            "name"=> "丹凤县",
                            "code"=> "611022"
                        ),
                        array(
                            "name"=> "商南县",
                            "code"=> "611023"
                        ),
                        array(
                            "name"=> "山阳县",
                            "code"=> "611024"
                        ),
                        array(
                            "name"=> "镇安县",
                            "code"=> "611025"
                        ),
                        array(
                            "name"=> "柞水县",
                            "code"=> "611026"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "甘肃省",
            "code"=> "620000",
            "sub"=> [
                array(
                    "name"=> "兰州市",
                    "code"=> "620100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620101"
                        ),
                        array(
                            "name"=> "城关区",
                            "code"=> "620102"
                        ),
                        array(
                            "name"=> "七里河区",
                            "code"=> "620103"
                        ),
                        array(
                            "name"=> "西固区",
                            "code"=> "620104"
                        ),
                        array(
                            "name"=> "安宁区",
                            "code"=> "620105"
                        ),
                        array(
                            "name"=> "红古区",
                            "code"=> "620111"
                        ),
                        array(
                            "name"=> "永登县",
                            "code"=> "620121"
                        ),
                        array(
                            "name"=> "皋兰县",
                            "code"=> "620122"
                        ),
                        array(
                            "name"=> "榆中县",
                            "code"=> "620123"
                        )
                    ]
                ),
                array(
                    "name"=> "嘉峪关市",
                    "code"=> "620200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620201"
                        )
                    ]
                ),
                array(
                    "name"=> "金昌市",
                    "code"=> "620300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620301"
                        ),
                        array(
                            "name"=> "金川区",
                            "code"=> "620302"
                        ),
                        array(
                            "name"=> "永昌县",
                            "code"=> "620321"
                        )
                    ]
                ),
                array(
                    "name"=> "白银市",
                    "code"=> "620400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620401"
                        ),
                        array(
                            "name"=> "白银区",
                            "code"=> "620402"
                        ),
                        array(
                            "name"=> "平川区",
                            "code"=> "620403"
                        ),
                        array(
                            "name"=> "靖远县",
                            "code"=> "620421"
                        ),
                        array(
                            "name"=> "会宁县",
                            "code"=> "620422"
                        ),
                        array(
                            "name"=> "景泰县",
                            "code"=> "620423"
                        )
                    ]
                ),
                array(
                    "name"=> "天水市",
                    "code"=> "620500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620501"
                        ),
                        array(
                            "name"=> "秦州区",
                            "code"=> "620502"
                        ),
                        array(
                            "name"=> "麦积区",
                            "code"=> "620503"
                        ),
                        array(
                            "name"=> "清水县",
                            "code"=> "620521"
                        ),
                        array(
                            "name"=> "秦安县",
                            "code"=> "620522"
                        ),
                        array(
                            "name"=> "甘谷县",
                            "code"=> "620523"
                        ),
                        array(
                            "name"=> "武山县",
                            "code"=> "620524"
                        ),
                        array(
                            "name"=> "张家川回族自治县",
                            "code"=> "620525"
                        )
                    ]
                ),
                array(
                    "name"=> "武威市",
                    "code"=> "620600",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620601"
                        ),
                        array(
                            "name"=> "凉州区",
                            "code"=> "620602"
                        ),
                        array(
                            "name"=> "民勤县",
                            "code"=> "620621"
                        ),
                        array(
                            "name"=> "古浪县",
                            "code"=> "620622"
                        ),
                        array(
                            "name"=> "天祝藏族自治县",
                            "code"=> "620623"
                        )
                    ]
                ),
                array(
                    "name"=> "张掖市",
                    "code"=> "620700",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620701"
                        ),
                        array(
                            "name"=> "甘州区",
                            "code"=> "620702"
                        ),
                        array(
                            "name"=> "肃南裕固族自治县",
                            "code"=> "620721"
                        ),
                        array(
                            "name"=> "民乐县",
                            "code"=> "620722"
                        ),
                        array(
                            "name"=> "临泽县",
                            "code"=> "620723"
                        ),
                        array(
                            "name"=> "高台县",
                            "code"=> "620724"
                        ),
                        array(
                            "name"=> "山丹县",
                            "code"=> "620725"
                        )
                    ]
                ),
                array(
                    "name"=> "平凉市",
                    "code"=> "620800",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620801"
                        ),
                        array(
                            "name"=> "崆峒区",
                            "code"=> "620802"
                        ),
                        array(
                            "name"=> "泾川县",
                            "code"=> "620821"
                        ),
                        array(
                            "name"=> "灵台县",
                            "code"=> "620822"
                        ),
                        array(
                            "name"=> "崇信县",
                            "code"=> "620823"
                        ),
                        array(
                            "name"=> "华亭县",
                            "code"=> "620824"
                        ),
                        array(
                            "name"=> "庄浪县",
                            "code"=> "620825"
                        ),
                        array(
                            "name"=> "静宁县",
                            "code"=> "620826"
                        )
                    ]
                ),
                array(
                    "name"=> "酒泉市",
                    "code"=> "620900",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "620901"
                        ),
                        array(
                            "name"=> "肃州区",
                            "code"=> "620902"
                        ),
                        array(
                            "name"=> "金塔县",
                            "code"=> "620921"
                        ),
                        array(
                            "name"=> "瓜州县",
                            "code"=> "620922"
                        ),
                        array(
                            "name"=> "肃北蒙古族自治县",
                            "code"=> "620923"
                        ),
                        array(
                            "name"=> "阿克塞哈萨克族自治县",
                            "code"=> "620924"
                        ),
                        array(
                            "name"=> "玉门市",
                            "code"=> "620981"
                        ),
                        array(
                            "name"=> "敦煌市",
                            "code"=> "620982"
                        )
                    ]
                ),
                array(
                    "name"=> "庆阳市",
                    "code"=> "621000",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "621001"
                        ),
                        array(
                            "name"=> "西峰区",
                            "code"=> "621002"
                        ),
                        array(
                            "name"=> "庆城县",
                            "code"=> "621021"
                        ),
                        array(
                            "name"=> "环县",
                            "code"=> "621022"
                        ),
                        array(
                            "name"=> "华池县",
                            "code"=> "621023"
                        ),
                        array(
                            "name"=> "合水县",
                            "code"=> "621024"
                        ),
                        array(
                            "name"=> "正宁县",
                            "code"=> "621025"
                        ),
                        array(
                            "name"=> "宁县",
                            "code"=> "621026"
                        ),
                        array(
                            "name"=> "镇原县",
                            "code"=> "621027"
                        )
                    ]
                ),
                array(
                    "name"=> "定西市",
                    "code"=> "621100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "621101"
                        ),
                        array(
                            "name"=> "安定区",
                            "code"=> "621102"
                        ),
                        array(
                            "name"=> "通渭县",
                            "code"=> "621121"
                        ),
                        array(
                            "name"=> "陇西县",
                            "code"=> "621122"
                        ),
                        array(
                            "name"=> "渭源县",
                            "code"=> "621123"
                        ),
                        array(
                            "name"=> "临洮县",
                            "code"=> "621124"
                        ),
                        array(
                            "name"=> "漳县",
                            "code"=> "621125"
                        ),
                        array(
                            "name"=> "岷县",
                            "code"=> "621126"
                        )
                    ]
                ),
                array(
                    "name"=> "陇南市",
                    "code"=> "621200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "621201"
                        ),
                        array(
                            "name"=> "武都区",
                            "code"=> "621202"
                        ),
                        array(
                            "name"=> "成县",
                            "code"=> "621221"
                        ),
                        array(
                            "name"=> "文县",
                            "code"=> "621222"
                        ),
                        array(
                            "name"=> "宕昌县",
                            "code"=> "621223"
                        ),
                        array(
                            "name"=> "康县",
                            "code"=> "621224"
                        ),
                        array(
                            "name"=> "西和县",
                            "code"=> "621225"
                        ),
                        array(
                            "name"=> "礼县",
                            "code"=> "621226"
                        ),
                        array(
                            "name"=> "徽县",
                            "code"=> "621227"
                        ),
                        array(
                            "name"=> "两当县",
                            "code"=> "621228"
                        )
                    ]
                ),
                array(
                    "name"=> "临夏回族自治州",
                    "code"=> "622900",
                    "sub"=> [
                        array(
                            "name"=> "临夏市",
                            "code"=> "622901"
                        ),
                        array(
                            "name"=> "临夏县",
                            "code"=> "622921"
                        ),
                        array(
                            "name"=> "康乐县",
                            "code"=> "622922"
                        ),
                        array(
                            "name"=> "永靖县",
                            "code"=> "622923"
                        ),
                        array(
                            "name"=> "广河县",
                            "code"=> "622924"
                        ),
                        array(
                            "name"=> "和政县",
                            "code"=> "622925"
                        ),
                        array(
                            "name"=> "东乡族自治县",
                            "code"=> "622926"
                        ),
                        array(
                            "name"=> "积石山保安族东乡族撒拉族自治县",
                            "code"=> "622927"
                        )
                    ]
                ),
                array(
                    "name"=> "甘南藏族自治州",
                    "code"=> "623000",
                    "sub"=> [
                        array(
                            "name"=> "合作市",
                            "code"=> "623001"
                        ),
                        array(
                            "name"=> "临潭县",
                            "code"=> "623021"
                        ),
                        array(
                            "name"=> "卓尼县",
                            "code"=> "623022"
                        ),
                        array(
                            "name"=> "舟曲县",
                            "code"=> "623023"
                        ),
                        array(
                            "name"=> "迭部县",
                            "code"=> "623024"
                        ),
                        array(
                            "name"=> "玛曲县",
                            "code"=> "623025"
                        ),
                        array(
                            "name"=> "碌曲县",
                            "code"=> "623026"
                        ),
                        array(
                            "name"=> "夏河县",
                            "code"=> "623027"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "青海省",
            "code"=> "630000",
            "sub"=> [
                array(
                    "name"=> "西宁市",
                    "code"=> "630100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "630101"
                        ),
                        array(
                            "name"=> "城东区",
                            "code"=> "630102"
                        ),
                        array(
                            "name"=> "城中区",
                            "code"=> "630103"
                        ),
                        array(
                            "name"=> "城西区",
                            "code"=> "630104"
                        ),
                        array(
                            "name"=> "城北区",
                            "code"=> "630105"
                        ),
                        array(
                            "name"=> "大通回族土族自治县",
                            "code"=> "630121"
                        ),
                        array(
                            "name"=> "湟中县",
                            "code"=> "630122"
                        ),
                        array(
                            "name"=> "湟源县",
                            "code"=> "630123"
                        )
                    ]
                ),
                array(
                    "name"=> "海东市",
                    "code"=> "630200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "630201"
                        ),
                        array(
                            "name"=> "乐都区",
                            "code"=> "630202"
                        ),
                        array(
                            "name"=> "平安县",
                            "code"=> "630221"
                        ),
                        array(
                            "name"=> "民和回族土族自治县",
                            "code"=> "630222"
                        ),
                        array(
                            "name"=> "互助土族自治县",
                            "code"=> "630223"
                        ),
                        array(
                            "name"=> "化隆回族自治县",
                            "code"=> "630224"
                        ),
                        array(
                            "name"=> "循化撒拉族自治县",
                            "code"=> "630225"
                        )
                    ]
                ),
                array(
                    "name"=> "海北藏族自治州",
                    "code"=> "632200",
                    "sub"=> [
                        array(
                            "name"=> "门源回族自治县",
                            "code"=> "632221"
                        ),
                        array(
                            "name"=> "祁连县",
                            "code"=> "632222"
                        ),
                        array(
                            "name"=> "海晏县",
                            "code"=> "632223"
                        ),
                        array(
                            "name"=> "刚察县",
                            "code"=> "632224"
                        )
                    ]
                ),
                array(
                    "name"=> "黄南藏族自治州",
                    "code"=> "632300",
                    "sub"=> [
                        array(
                            "name"=> "同仁县",
                            "code"=> "632321"
                        ),
                        array(
                            "name"=> "尖扎县",
                            "code"=> "632322"
                        ),
                        array(
                            "name"=> "泽库县",
                            "code"=> "632323"
                        ),
                        array(
                            "name"=> "河南蒙古族自治县",
                            "code"=> "632324"
                        )
                    ]
                ),
                array(
                    "name"=> "海南藏族自治州",
                    "code"=> "632500",
                    "sub"=> [
                        array(
                            "name"=> "共和县",
                            "code"=> "632521"
                        ),
                        array(
                            "name"=> "同德县",
                            "code"=> "632522"
                        ),
                        array(
                            "name"=> "贵德县",
                            "code"=> "632523"
                        ),
                        array(
                            "name"=> "兴海县",
                            "code"=> "632524"
                        ),
                        array(
                            "name"=> "贵南县",
                            "code"=> "632525"
                        )
                    ]
                ),
                array(
                    "name"=> "果洛藏族自治州",
                    "code"=> "632600",
                    "sub"=> [
                        array(
                            "name"=> "玛沁县",
                            "code"=> "632621"
                        ),
                        array(
                            "name"=> "班玛县",
                            "code"=> "632622"
                        ),
                        array(
                            "name"=> "甘德县",
                            "code"=> "632623"
                        ),
                        array(
                            "name"=> "达日县",
                            "code"=> "632624"
                        ),
                        array(
                            "name"=> "久治县",
                            "code"=> "632625"
                        ),
                        array(
                            "name"=> "玛多县",
                            "code"=> "632626"
                        )
                    ]
                ),
                array(
                    "name"=> "玉树藏族自治州",
                    "code"=> "632700",
                    "sub"=> [
                        array(
                            "name"=> "玉树市",
                            "code"=> "632701"
                        ),
                        array(
                            "name"=> "杂多县",
                            "code"=> "632722"
                        ),
                        array(
                            "name"=> "称多县",
                            "code"=> "632723"
                        ),
                        array(
                            "name"=> "治多县",
                            "code"=> "632724"
                        ),
                        array(
                            "name"=> "囊谦县",
                            "code"=> "632725"
                        ),
                        array(
                            "name"=> "曲麻莱县",
                            "code"=> "632726"
                        )
                    ]
                ),
                array(
                    "name"=> "海西蒙古族藏族自治州",
                    "code"=> "632800",
                    "sub"=> [
                        array(
                            "name"=> "格尔木市",
                            "code"=> "632801"
                        ),
                        array(
                            "name"=> "德令哈市",
                            "code"=> "632802"
                        ),
                        array(
                            "name"=> "乌兰县",
                            "code"=> "632821"
                        ),
                        array(
                            "name"=> "都兰县",
                            "code"=> "632822"
                        ),
                        array(
                            "name"=> "天峻县",
                            "code"=> "632823"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "宁夏回族自治区",
            "code"=> "640000",
            "sub"=> [
                array(
                    "name"=> "银川市",
                    "code"=> "640100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "640101"
                        ),
                        array(
                            "name"=> "兴庆区",
                            "code"=> "640104"
                        ),
                        array(
                            "name"=> "西夏区",
                            "code"=> "640105"
                        ),
                        array(
                            "name"=> "金凤区",
                            "code"=> "640106"
                        ),
                        array(
                            "name"=> "永宁县",
                            "code"=> "640121"
                        ),
                        array(
                            "name"=> "贺兰县",
                            "code"=> "640122"
                        ),
                        array(
                            "name"=> "灵武市",
                            "code"=> "640181"
                        )
                    ]
                ),
                array(
                    "name"=> "石嘴山市",
                    "code"=> "640200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "640201"
                        ),
                        array(
                            "name"=> "大武口区",
                            "code"=> "640202"
                        ),
                        array(
                            "name"=> "惠农区",
                            "code"=> "640205"
                        ),
                        array(
                            "name"=> "平罗县",
                            "code"=> "640221"
                        )
                    ]
                ),
                array(
                    "name"=> "吴忠市",
                    "code"=> "640300",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "640301"
                        ),
                        array(
                            "name"=> "利通区",
                            "code"=> "640302"
                        ),
                        array(
                            "name"=> "红寺堡区",
                            "code"=> "640303"
                        ),
                        array(
                            "name"=> "盐池县",
                            "code"=> "640323"
                        ),
                        array(
                            "name"=> "同心县",
                            "code"=> "640324"
                        ),
                        array(
                            "name"=> "青铜峡市",
                            "code"=> "640381"
                        )
                    ]
                ),
                array(
                    "name"=> "固原市",
                    "code"=> "640400",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "640401"
                        ),
                        array(
                            "name"=> "原州区",
                            "code"=> "640402"
                        ),
                        array(
                            "name"=> "西吉县",
                            "code"=> "640422"
                        ),
                        array(
                            "name"=> "隆德县",
                            "code"=> "640423"
                        ),
                        array(
                            "name"=> "泾源县",
                            "code"=> "640424"
                        ),
                        array(
                            "name"=> "彭阳县",
                            "code"=> "640425"
                        )
                    ]
                ),
                array(
                    "name"=> "中卫市",
                    "code"=> "640500",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "640501"
                        ),
                        array(
                            "name"=> "沙坡头区",
                            "code"=> "640502"
                        ),
                        array(
                            "name"=> "中宁县",
                            "code"=> "640521"
                        ),
                        array(
                            "name"=> "海原县",
                            "code"=> "640522"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "新疆维吾尔自治区",
            "code"=> "650000",
            "sub"=> [
                array(
                    "name"=> "乌鲁木齐市",
                    "code"=> "650100",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "650101"
                        ),
                        array(
                            "name"=> "天山区",
                            "code"=> "650102"
                        ),
                        array(
                            "name"=> "沙依巴克区",
                            "code"=> "650103"
                        ),
                        array(
                            "name"=> "新市区",
                            "code"=> "650104"
                        ),
                        array(
                            "name"=> "水磨沟区",
                            "code"=> "650105"
                        ),
                        array(
                            "name"=> "头屯河区",
                            "code"=> "650106"
                        ),
                        array(
                            "name"=> "达坂城区",
                            "code"=> "650107"
                        ),
                        array(
                            "name"=> "米东区",
                            "code"=> "650109"
                        ),
                        array(
                            "name"=> "乌鲁木齐县",
                            "code"=> "650121"
                        )
                    ]
                ),
                array(
                    "name"=> "克拉玛依市",
                    "code"=> "650200",
                    "sub"=> [
                        array(
                            "name"=> "市辖区",
                            "code"=> "650201"
                        ),
                        array(
                            "name"=> "独山子区",
                            "code"=> "650202"
                        ),
                        array(
                            "name"=> "克拉玛依区",
                            "code"=> "650203"
                        ),
                        array(
                            "name"=> "白碱滩区",
                            "code"=> "650204"
                        ),
                        array(
                            "name"=> "乌尔禾区",
                            "code"=> "650205"
                        )
                    ]
                ),
                array(
                    "name"=> "吐鲁番地区",
                    "code"=> "652100",
                    "sub"=> [
                        array(
                            "name"=> "吐鲁番市",
                            "code"=> "652101"
                        ),
                        array(
                            "name"=> "鄯善县",
                            "code"=> "652122"
                        ),
                        array(
                            "name"=> "托克逊县",
                            "code"=> "652123"
                        )
                    ]
                ),
                array(
                    "name"=> "哈密地区",
                    "code"=> "652200",
                    "sub"=> [
                        array(
                            "name"=> "哈密市",
                            "code"=> "652201"
                        ),
                        array(
                            "name"=> "巴里坤哈萨克自治县",
                            "code"=> "652222"
                        ),
                        array(
                            "name"=> "伊吾县",
                            "code"=> "652223"
                        )
                    ]
                ),
                array(
                    "name"=> "昌吉回族自治州",
                    "code"=> "652300",
                    "sub"=> [
                        array(
                            "name"=> "昌吉市",
                            "code"=> "652301"
                        ),
                        array(
                            "name"=> "阜康市",
                            "code"=> "652302"
                        ),
                        array(
                            "name"=> "呼图壁县",
                            "code"=> "652323"
                        ),
                        array(
                            "name"=> "玛纳斯县",
                            "code"=> "652324"
                        ),
                        array(
                            "name"=> "奇台县",
                            "code"=> "652325"
                        ),
                        array(
                            "name"=> "吉木萨尔县",
                            "code"=> "652327"
                        ),
                        array(
                            "name"=> "木垒哈萨克自治县",
                            "code"=> "652328"
                        )
                    ]
                ),
                array(
                    "name"=> "博尔塔拉蒙古自治州",
                    "code"=> "652700",
                    "sub"=> [
                        array(
                            "name"=> "博乐市",
                            "code"=> "652701"
                        ),
                        array(
                            "name"=> "阿拉山口市",
                            "code"=> "652702"
                        ),
                        array(
                            "name"=> "精河县",
                            "code"=> "652722"
                        ),
                        array(
                            "name"=> "温泉县",
                            "code"=> "652723"
                        )
                    ]
                ),
                array(
                    "name"=> "巴音郭楞蒙古自治州",
                    "code"=> "652800",
                    "sub"=> [
                        array(
                            "name"=> "库尔勒市",
                            "code"=> "652801"
                        ),
                        array(
                            "name"=> "轮台县",
                            "code"=> "652822"
                        ),
                        array(
                            "name"=> "尉犁县",
                            "code"=> "652823"
                        ),
                        array(
                            "name"=> "若羌县",
                            "code"=> "652824"
                        ),
                        array(
                            "name"=> "且末县",
                            "code"=> "652825"
                        ),
                        array(
                            "name"=> "焉耆回族自治县",
                            "code"=> "652826"
                        ),
                        array(
                            "name"=> "和静县",
                            "code"=> "652827"
                        ),
                        array(
                            "name"=> "和硕县",
                            "code"=> "652828"
                        ),
                        array(
                            "name"=> "博湖县",
                            "code"=> "652829"
                        )
                    ]
                ),
                array(
                    "name"=> "阿克苏地区",
                    "code"=> "652900",
                    "sub"=> [
                        array(
                            "name"=> "阿克苏市",
                            "code"=> "652901"
                        ),
                        array(
                            "name"=> "温宿县",
                            "code"=> "652922"
                        ),
                        array(
                            "name"=> "库车县",
                            "code"=> "652923"
                        ),
                        array(
                            "name"=> "沙雅县",
                            "code"=> "652924"
                        ),
                        array(
                            "name"=> "新和县",
                            "code"=> "652925"
                        ),
                        array(
                            "name"=> "拜城县",
                            "code"=> "652926"
                        ),
                        array(
                            "name"=> "乌什县",
                            "code"=> "652927"
                        ),
                        array(
                            "name"=> "阿瓦提县",
                            "code"=> "652928"
                        ),
                        array(
                            "name"=> "柯坪县",
                            "code"=> "652929"
                        )
                    ]
                ),
                array(
                    "name"=> "克孜勒苏柯尔克孜自治州",
                    "code"=> "653000",
                    "sub"=> [
                        array(
                            "name"=> "阿图什市",
                            "code"=> "653001"
                        ),
                        array(
                            "name"=> "阿克陶县",
                            "code"=> "653022"
                        ),
                        array(
                            "name"=> "阿合奇县",
                            "code"=> "653023"
                        ),
                        array(
                            "name"=> "乌恰县",
                            "code"=> "653024"
                        )
                    ]
                ),
                array(
                    "name"=> "喀什地区",
                    "code"=> "653100",
                    "sub"=> [
                        array(
                            "name"=> "喀什市",
                            "code"=> "653101"
                        ),
                        array(
                            "name"=> "疏附县",
                            "code"=> "653121"
                        ),
                        array(
                            "name"=> "疏勒县",
                            "code"=> "653122"
                        ),
                        array(
                            "name"=> "英吉沙县",
                            "code"=> "653123"
                        ),
                        array(
                            "name"=> "泽普县",
                            "code"=> "653124"
                        ),
                        array(
                            "name"=> "莎车县",
                            "code"=> "653125"
                        ),
                        array(
                            "name"=> "叶城县",
                            "code"=> "653126"
                        ),
                        array(
                            "name"=> "麦盖提县",
                            "code"=> "653127"
                        ),
                        array(
                            "name"=> "岳普湖县",
                            "code"=> "653128"
                        ),
                        array(
                            "name"=> "伽师县",
                            "code"=> "653129"
                        ),
                        array(
                            "name"=> "巴楚县",
                            "code"=> "653130"
                        ),
                        array(
                            "name"=> "塔什库尔干塔吉克自治县",
                            "code"=> "653131"
                        )
                    ]
                ),
                array(
                    "name"=> "和田地区",
                    "code"=> "653200",
                    "sub"=> [
                        array(
                            "name"=> "和田市",
                            "code"=> "653201"
                        ),
                        array(
                            "name"=> "和田县",
                            "code"=> "653221"
                        ),
                        array(
                            "name"=> "墨玉县",
                            "code"=> "653222"
                        ),
                        array(
                            "name"=> "皮山县",
                            "code"=> "653223"
                        ),
                        array(
                            "name"=> "洛浦县",
                            "code"=> "653224"
                        ),
                        array(
                            "name"=> "策勒县",
                            "code"=> "653225"
                        ),
                        array(
                            "name"=> "于田县",
                            "code"=> "653226"
                        ),
                        array(
                            "name"=> "民丰县",
                            "code"=> "653227"
                        )
                    ]
                ),
                array(
                    "name"=> "伊犁哈萨克自治州",
                    "code"=> "654000",
                    "sub"=> [
                        array(
                            "name"=> "伊宁市",
                            "code"=> "654002"
                        ),
                        array(
                            "name"=> "奎屯市",
                            "code"=> "654003"
                        ),
                        array(
                            "name"=> "霍尔果斯市",
                            "code"=> "654004"
                        ),
                        array(
                            "name"=> "伊宁县",
                            "code"=> "654021"
                        ),
                        array(
                            "name"=> "察布查尔锡伯自治县",
                            "code"=> "654022"
                        ),
                        array(
                            "name"=> "霍城县",
                            "code"=> "654023"
                        ),
                        array(
                            "name"=> "巩留县",
                            "code"=> "654024"
                        ),
                        array(
                            "name"=> "新源县",
                            "code"=> "654025"
                        ),
                        array(
                            "name"=> "昭苏县",
                            "code"=> "654026"
                        ),
                        array(
                            "name"=> "特克斯县",
                            "code"=> "654027"
                        ),
                        array(
                            "name"=> "尼勒克县",
                            "code"=> "654028"
                        ),
                        array(
                            "name"=> "塔城地区",
                            "code"=> "654200"
                        ),
                        array(
                            "name"=> "塔城市",
                            "code"=> "654201"
                        ),
                        array(
                            "name"=> "乌苏市",
                            "code"=> "654202"
                        ),
                        array(
                            "name"=> "额敏县",
                            "code"=> "654221"
                        ),
                        array(
                            "name"=> "沙湾县",
                            "code"=> "654223"
                        ),
                        array(
                            "name"=> "托里县",
                            "code"=> "654224"
                        ),
                        array(
                            "name"=> "裕民县",
                            "code"=> "654225"
                        ),
                        array(
                            "name"=> "和布克赛尔蒙古自治县",
                            "code"=> "654226"
                        ),
                        array(
                            "name"=> "阿勒泰地区",
                            "code"=> "654300"
                        ),
                        array(
                            "name"=> "阿勒泰市",
                            "code"=> "654301"
                        ),
                        array(
                            "name"=> "布尔津县",
                            "code"=> "654321"
                        ),
                        array(
                            "name"=> "富蕴县",
                            "code"=> "654322"
                        ),
                        array(
                            "name"=> "福海县",
                            "code"=> "654323"
                        ),
                        array(
                            "name"=> "哈巴河县",
                            "code"=> "654324"
                        ),
                        array(
                            "name"=> "青河县",
                            "code"=> "654325"
                        ),
                        array(
                            "name"=> "吉木乃县",
                            "code"=> "654326"
                        )
                    ]
                ),
                array(
                    "name"=> "自治区直辖县级行政区划",
                    "code"=> "659000",
                    "sub"=> [
                        array(
                            "name"=> "石河子市",
                            "code"=> "659001"
                        ),
                        array(
                            "name"=> "阿拉尔市",
                            "code"=> "659002"
                        ),
                        array(
                            "name"=> "图木舒克市",
                            "code"=> "659003"
                        ),
                        array(
                            "name"=> "五家渠市",
                            "code"=> "659004"
                        ),
                        array(
                            "name"=> "北屯市",
                            "code"=> "659005"
                        ),
                        array(
                            "name"=> "铁门关市",
                            "code"=> "659006"
                        ),
                        array(
                            "name"=> "双河市",
                            "code"=> "659007"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "台湾省",
            "code"=> "710000",
            "sub"=> [
                array(
                    "name"=> "台北市",
                    "code"=> "710100",
                    "sub"=> [
                        array(
                            "name"=> "松山区",
                            "code"=> "710101"
                        ),
                        array(
                            "name"=> "信义区",
                            "code"=> "710102"
                        ),
                        array(
                            "name"=> "大安区",
                            "code"=> "710103"
                        ),
                        array(
                            "name"=> "中山区",
                            "code"=> "710104"
                        ),
                        array(
                            "name"=> "中正区",
                            "code"=> "710105"
                        ),
                        array(
                            "name"=> "大同区",
                            "code"=> "710106"
                        ),
                        array(
                            "name"=> "万华区",
                            "code"=> "710107"
                        ),
                        array(
                            "name"=> "文山区",
                            "code"=> "710108"
                        ),
                        array(
                            "name"=> "南港区",
                            "code"=> "710109"
                        ),
                        array(
                            "name"=> "内湖区",
                            "code"=> "710110"
                        ),
                        array(
                            "name"=> "士林区",
                            "code"=> "710111"
                        ),
                        array(
                            "name"=> "北投区",
                            "code"=> "710112"
                        )
                    ]
                ),
                array(
                    "name"=> "高雄市",
                    "code"=> "710200",
                    "sub"=> [
                        array(
                            "name"=> "盐埕区",
                            "code"=> "710201"
                        ),
                        array(
                            "name"=> "鼓山区",
                            "code"=> "710202"
                        ),
                        array(
                            "name"=> "左营区",
                            "code"=> "710203"
                        ),
                        array(
                            "name"=> "楠梓区",
                            "code"=> "710204"
                        ),
                        array(
                            "name"=> "三民区",
                            "code"=> "710205"
                        ),
                        array(
                            "name"=> "新兴区",
                            "code"=> "710206"
                        ),
                        array(
                            "name"=> "前金区",
                            "code"=> "710207"
                        ),
                        array(
                            "name"=> "苓雅区",
                            "code"=> "710208"
                        ),
                        array(
                            "name"=> "前镇区",
                            "code"=> "710209"
                        ),
                        array(
                            "name"=> "旗津区",
                            "code"=> "710210"
                        ),
                        array(
                            "name"=> "小港区",
                            "code"=> "710211"
                        ),
                        array(
                            "name"=> "凤山区",
                            "code"=> "710212"
                        ),
                        array(
                            "name"=> "林园区",
                            "code"=> "710213"
                        ),
                        array(
                            "name"=> "大寮区",
                            "code"=> "710214"
                        ),
                        array(
                            "name"=> "大树区",
                            "code"=> "710215"
                        ),
                        array(
                            "name"=> "大社区",
                            "code"=> "710216"
                        ),
                        array(
                            "name"=> "仁武区",
                            "code"=> "710217"
                        ),
                        array(
                            "name"=> "鸟松区",
                            "code"=> "710218"
                        ),
                        array(
                            "name"=> "冈山区",
                            "code"=> "710219"
                        ),
                        array(
                            "name"=> "桥头区",
                            "code"=> "710220"
                        ),
                        array(
                            "name"=> "燕巢区",
                            "code"=> "710221"
                        ),
                        array(
                            "name"=> "田寮区",
                            "code"=> "710222"
                        ),
                        array(
                            "name"=> "阿莲区",
                            "code"=> "710223"
                        ),
                        array(
                            "name"=> "路竹区",
                            "code"=> "710224"
                        ),
                        array(
                            "name"=> "湖内区",
                            "code"=> "710225"
                        ),
                        array(
                            "name"=> "茄萣区",
                            "code"=> "710226"
                        ),
                        array(
                            "name"=> "永安区",
                            "code"=> "710227"
                        ),
                        array(
                            "name"=> "弥陀区",
                            "code"=> "710228"
                        ),
                        array(
                            "name"=> "梓官区",
                            "code"=> "710229"
                        ),
                        array(
                            "name"=> "旗山区",
                            "code"=> "710230"
                        ),
                        array(
                            "name"=> "美浓区",
                            "code"=> "710231"
                        ),
                        array(
                            "name"=> "六龟区",
                            "code"=> "710232"
                        ),
                        array(
                            "name"=> "甲仙区",
                            "code"=> "710233"
                        ),
                        array(
                            "name"=> "杉林区",
                            "code"=> "710234"
                        ),
                        array(
                            "name"=> "内门区",
                            "code"=> "710235"
                        ),
                        array(
                            "name"=> "茂林区",
                            "code"=> "710236"
                        ),
                        array(
                            "name"=> "桃源区",
                            "code"=> "710237"
                        ),
                        array(
                            "name"=> "那玛夏区",
                            "code"=> "710238"
                        )
                    ]
                ),
                array(
                    "name"=> "基隆市",
                    "code"=> "710300",
                    "sub"=> [
                        array(
                            "name"=> "中正区",
                            "code"=> "710301"
                        ),
                        array(
                            "name"=> "七堵区",
                            "code"=> "710302"
                        ),
                        array(
                            "name"=> "暖暖区",
                            "code"=> "710303"
                        ),
                        array(
                            "name"=> "仁爱区",
                            "code"=> "710304"
                        ),
                        array(
                            "name"=> "中山区",
                            "code"=> "710305"
                        ),
                        array(
                            "name"=> "安乐区",
                            "code"=> "710306"
                        ),
                        array(
                            "name"=> "信义区",
                            "code"=> "710307"
                        )
                    ]
                ),
                array(
                    "name"=> "台中市",
                    "code"=> "710400",
                    "sub"=> [
                        array(
                            "name"=> "中区",
                            "code"=> "710401"
                        ),
                        array(
                            "name"=> "东区",
                            "code"=> "710402"
                        ),
                        array(
                            "name"=> "南区",
                            "code"=> "710403"
                        ),
                        array(
                            "name"=> "西区",
                            "code"=> "710404"
                        ),
                        array(
                            "name"=> "北区",
                            "code"=> "710405"
                        ),
                        array(
                            "name"=> "西屯区",
                            "code"=> "710406"
                        ),
                        array(
                            "name"=> "南屯区",
                            "code"=> "710407"
                        ),
                        array(
                            "name"=> "北屯区",
                            "code"=> "710408"
                        ),
                        array(
                            "name"=> "丰原区",
                            "code"=> "710409"
                        ),
                        array(
                            "name"=> "东势区",
                            "code"=> "710410"
                        ),
                        array(
                            "name"=> "大甲区",
                            "code"=> "710411"
                        ),
                        array(
                            "name"=> "清水区",
                            "code"=> "710412"
                        ),
                        array(
                            "name"=> "沙鹿区",
                            "code"=> "710413"
                        ),
                        array(
                            "name"=> "梧栖区",
                            "code"=> "710414"
                        ),
                        array(
                            "name"=> "后里区",
                            "code"=> "710415"
                        ),
                        array(
                            "name"=> "神冈区",
                            "code"=> "710416"
                        ),
                        array(
                            "name"=> "潭子区",
                            "code"=> "710417"
                        ),
                        array(
                            "name"=> "大雅区",
                            "code"=> "710418"
                        ),
                        array(
                            "name"=> "新社区",
                            "code"=> "710419"
                        ),
                        array(
                            "name"=> "石冈区",
                            "code"=> "710420"
                        ),
                        array(
                            "name"=> "外埔区",
                            "code"=> "710421"
                        ),
                        array(
                            "name"=> "大安区",
                            "code"=> "710422"
                        ),
                        array(
                            "name"=> "乌日区",
                            "code"=> "710423"
                        ),
                        array(
                            "name"=> "大肚区",
                            "code"=> "710424"
                        ),
                        array(
                            "name"=> "龙井区",
                            "code"=> "710425"
                        ),
                        array(
                            "name"=> "雾峰区",
                            "code"=> "710426"
                        ),
                        array(
                            "name"=> "太平区",
                            "code"=> "710427"
                        ),
                        array(
                            "name"=> "大里区",
                            "code"=> "710428"
                        ),
                        array(
                            "name"=> "和平区",
                            "code"=> "710429"
                        )
                    ]
                ),
                array(
                    "name"=> "台南市",
                    "code"=> "710500",
                    "sub"=> [
                        array(
                            "name"=> "东区",
                            "code"=> "710501"
                        ),
                        array(
                            "name"=> "南区",
                            "code"=> "710502"
                        ),
                        array(
                            "name"=> "北区",
                            "code"=> "710504"
                        ),
                        array(
                            "name"=> "安南区",
                            "code"=> "710506"
                        ),
                        array(
                            "name"=> "安平区",
                            "code"=> "710507"
                        ),
                        array(
                            "name"=> "中西区",
                            "code"=> "710508"
                        ),
                        array(
                            "name"=> "新营区",
                            "code"=> "710509"
                        ),
                        array(
                            "name"=> "盐水区",
                            "code"=> "710510"
                        ),
                        array(
                            "name"=> "白河区",
                            "code"=> "710511"
                        ),
                        array(
                            "name"=> "柳营区",
                            "code"=> "710512"
                        ),
                        array(
                            "name"=> "后壁区",
                            "code"=> "710513"
                        ),
                        array(
                            "name"=> "东山区",
                            "code"=> "710514"
                        ),
                        array(
                            "name"=> "麻豆区",
                            "code"=> "710515"
                        ),
                        array(
                            "name"=> "下营区",
                            "code"=> "710516"
                        ),
                        array(
                            "name"=> "六甲区",
                            "code"=> "710517"
                        ),
                        array(
                            "name"=> "官田区",
                            "code"=> "710518"
                        ),
                        array(
                            "name"=> "大内区",
                            "code"=> "710519"
                        ),
                        array(
                            "name"=> "佳里区",
                            "code"=> "710520"
                        ),
                        array(
                            "name"=> "学甲区",
                            "code"=> "710521"
                        ),
                        array(
                            "name"=> "西港区",
                            "code"=> "710522"
                        ),
                        array(
                            "name"=> "七股区",
                            "code"=> "710523"
                        ),
                        array(
                            "name"=> "将军区",
                            "code"=> "710524"
                        ),
                        array(
                            "name"=> "北门区",
                            "code"=> "710525"
                        ),
                        array(
                            "name"=> "新化区",
                            "code"=> "710526"
                        ),
                        array(
                            "name"=> "善化区",
                            "code"=> "710527"
                        ),
                        array(
                            "name"=> "新市区",
                            "code"=> "710528"
                        ),
                        array(
                            "name"=> "安定区",
                            "code"=> "710529"
                        ),
                        array(
                            "name"=> "山上区",
                            "code"=> "710530"
                        ),
                        array(
                            "name"=> "玉井区",
                            "code"=> "710531"
                        ),
                        array(
                            "name"=> "楠西区",
                            "code"=> "710532"
                        ),
                        array(
                            "name"=> "南化区",
                            "code"=> "710533"
                        ),
                        array(
                            "name"=> "左镇区",
                            "code"=> "710534"
                        ),
                        array(
                            "name"=> "仁德区",
                            "code"=> "710535"
                        ),
                        array(
                            "name"=> "归仁区",
                            "code"=> "710536"
                        ),
                        array(
                            "name"=> "关庙区",
                            "code"=> "710537"
                        ),
                        array(
                            "name"=> "龙崎区",
                            "code"=> "710538"
                        ),
                        array(
                            "name"=> "永康区",
                            "code"=> "710539"
                        )
                    ]
                ),
                array(
                    "name"=> "新竹市",
                    "code"=> "710600",
                    "sub"=> [
                        array(
                            "name"=> "东区",
                            "code"=> "710601"
                        ),
                        array(
                            "name"=> "北区",
                            "code"=> "710602"
                        ),
                        array(
                            "name"=> "香山区",
                            "code"=> "710603"
                        )
                    ]
                ),
                array(
                    "name"=> "嘉义市",
                    "code"=> "710700",
                    "sub"=> [
                        array(
                            "name"=> "东区",
                            "code"=> "710701"
                        ),
                        array(
                            "name"=> "西区",
                            "code"=> "710702"
                        )
                    ]
                ),
                array(
                    "name"=> "新北市",
                    "code"=> "710800",
                    "sub"=> [
                        array(
                            "name"=> "板桥区",
                            "code"=> "710801"
                        ),
                        array(
                            "name"=> "三重区",
                            "code"=> "710802"
                        ),
                        array(
                            "name"=> "中和区",
                            "code"=> "710803"
                        ),
                        array(
                            "name"=> "永和区",
                            "code"=> "710804"
                        ),
                        array(
                            "name"=> "新庄区",
                            "code"=> "710805"
                        ),
                        array(
                            "name"=> "新店区",
                            "code"=> "710806"
                        ),
                        array(
                            "name"=> "树林区",
                            "code"=> "710807"
                        ),
                        array(
                            "name"=> "莺歌区",
                            "code"=> "710808"
                        ),
                        array(
                            "name"=> "三峡区",
                            "code"=> "710809"
                        ),
                        array(
                            "name"=> "淡水区",
                            "code"=> "710810"
                        ),
                        array(
                            "name"=> "汐止区",
                            "code"=> "710811"
                        ),
                        array(
                            "name"=> "瑞芳区",
                            "code"=> "710812"
                        ),
                        array(
                            "name"=> "土城区",
                            "code"=> "710813"
                        ),
                        array(
                            "name"=> "芦洲区",
                            "code"=> "710814"
                        ),
                        array(
                            "name"=> "五股区",
                            "code"=> "710815"
                        ),
                        array(
                            "name"=> "泰山区",
                            "code"=> "710816"
                        ),
                        array(
                            "name"=> "林口区",
                            "code"=> "710817"
                        ),
                        array(
                            "name"=> "深坑区",
                            "code"=> "710818"
                        ),
                        array(
                            "name"=> "石碇区",
                            "code"=> "710819"
                        ),
                        array(
                            "name"=> "坪林区",
                            "code"=> "710820"
                        ),
                        array(
                            "name"=> "三芝区",
                            "code"=> "710821"
                        ),
                        array(
                            "name"=> "石门区",
                            "code"=> "710822"
                        ),
                        array(
                            "name"=> "八里区",
                            "code"=> "710823"
                        ),
                        array(
                            "name"=> "平溪区",
                            "code"=> "710824"
                        ),
                        array(
                            "name"=> "双溪区",
                            "code"=> "710825"
                        ),
                        array(
                            "name"=> "贡寮区",
                            "code"=> "710826"
                        ),
                        array(
                            "name"=> "金山区",
                            "code"=> "710827"
                        ),
                        array(
                            "name"=> "万里区",
                            "code"=> "710828"
                        ),
                        array(
                            "name"=> "乌来区",
                            "code"=> "710829"
                        )
                    ]
                ),
                array(
                    "name"=> "宜兰县",
                    "code"=> "712200",
                    "sub"=> [
                        array(
                            "name"=> "宜兰市",
                            "code"=> "712201"
                        ),
                        array(
                            "name"=> "罗东镇",
                            "code"=> "712221"
                        ),
                        array(
                            "name"=> "苏澳镇",
                            "code"=> "712222"
                        ),
                        array(
                            "name"=> "头城镇",
                            "code"=> "712223"
                        ),
                        array(
                            "name"=> "礁溪乡",
                            "code"=> "712224"
                        ),
                        array(
                            "name"=> "壮围乡",
                            "code"=> "712225"
                        ),
                        array(
                            "name"=> "员山乡",
                            "code"=> "712226"
                        ),
                        array(
                            "name"=> "冬山乡",
                            "code"=> "712227"
                        ),
                        array(
                            "name"=> "五结乡",
                            "code"=> "712228"
                        ),
                        array(
                            "name"=> "三星乡",
                            "code"=> "712229"
                        ),
                        array(
                            "name"=> "大同乡",
                            "code"=> "712230"
                        ),
                        array(
                            "name"=> "南澳乡",
                            "code"=> "712231"
                        )
                    ]
                ),
                array(
                    "name"=> "桃园县",
                    "code"=> "712300",
                    "sub"=> [
                        array(
                            "name"=> "桃园市",
                            "code"=> "712301"
                        ),
                        array(
                            "name"=> "中坜市",
                            "code"=> "712302"
                        ),
                        array(
                            "name"=> "平镇市",
                            "code"=> "712303"
                        ),
                        array(
                            "name"=> "八德市",
                            "code"=> "712304"
                        ),
                        array(
                            "name"=> "杨梅市",
                            "code"=> "712305"
                        ),
                        array(
                            "name"=> "大溪镇",
                            "code"=> "712321"
                        ),
                        array(
                            "name"=> "芦竹乡",
                            "code"=> "712323"
                        ),
                        array(
                            "name"=> "大园乡",
                            "code"=> "712324"
                        ),
                        array(
                            "name"=> "龟山乡",
                            "code"=> "712325"
                        ),
                        array(
                            "name"=> "龙潭乡",
                            "code"=> "712327"
                        ),
                        array(
                            "name"=> "新屋乡",
                            "code"=> "712329"
                        ),
                        array(
                            "name"=> "观音乡",
                            "code"=> "712330"
                        ),
                        array(
                            "name"=> "复兴乡",
                            "code"=> "712331"
                        )
                    ]
                ),
                array(
                    "name"=> "新竹县",
                    "code"=> "712400",
                    "sub"=> [
                        array(
                            "name"=> "竹北市",
                            "code"=> "712401"
                        ),
                        array(
                            "name"=> "竹东镇",
                            "code"=> "712421"
                        ),
                        array(
                            "name"=> "新埔镇",
                            "code"=> "712422"
                        ),
                        array(
                            "name"=> "关西镇",
                            "code"=> "712423"
                        ),
                        array(
                            "name"=> "湖口乡",
                            "code"=> "712424"
                        ),
                        array(
                            "name"=> "新丰乡",
                            "code"=> "712425"
                        ),
                        array(
                            "name"=> "芎林乡",
                            "code"=> "712426"
                        ),
                        array(
                            "name"=> "橫山乡",
                            "code"=> "712427"
                        ),
                        array(
                            "name"=> "北埔乡",
                            "code"=> "712428"
                        ),
                        array(
                            "name"=> "宝山乡",
                            "code"=> "712429"
                        ),
                        array(
                            "name"=> "峨眉乡",
                            "code"=> "712430"
                        ),
                        array(
                            "name"=> "尖石乡",
                            "code"=> "712431"
                        ),
                        array(
                            "name"=> "五峰乡",
                            "code"=> "712432"
                        )
                    ]
                ),
                array(
                    "name"=> "苗栗县",
                    "code"=> "712500",
                    "sub"=> [
                        array(
                            "name"=> "苗栗市",
                            "code"=> "712501"
                        ),
                        array(
                            "name"=> "苑里镇",
                            "code"=> "712521"
                        ),
                        array(
                            "name"=> "通霄镇",
                            "code"=> "712522"
                        ),
                        array(
                            "name"=> "竹南镇",
                            "code"=> "712523"
                        ),
                        array(
                            "name"=> "头份镇",
                            "code"=> "712524"
                        ),
                        array(
                            "name"=> "后龙镇",
                            "code"=> "712525"
                        ),
                        array(
                            "name"=> "卓兰镇",
                            "code"=> "712526"
                        ),
                        array(
                            "name"=> "大湖乡",
                            "code"=> "712527"
                        ),
                        array(
                            "name"=> "公馆乡",
                            "code"=> "712528"
                        ),
                        array(
                            "name"=> "铜锣乡",
                            "code"=> "712529"
                        ),
                        array(
                            "name"=> "南庄乡",
                            "code"=> "712530"
                        ),
                        array(
                            "name"=> "头屋乡",
                            "code"=> "712531"
                        ),
                        array(
                            "name"=> "三义乡",
                            "code"=> "712532"
                        ),
                        array(
                            "name"=> "西湖乡",
                            "code"=> "712533"
                        ),
                        array(
                            "name"=> "造桥乡",
                            "code"=> "712534"
                        ),
                        array(
                            "name"=> "三湾乡",
                            "code"=> "712535"
                        ),
                        array(
                            "name"=> "狮潭乡",
                            "code"=> "712536"
                        ),
                        array(
                            "name"=> "泰安乡",
                            "code"=> "712537"
                        )
                    ]
                ),
                array(
                    "name"=> "彰化县",
                    "code"=> "712700",
                    "sub"=> [
                        array(
                            "name"=> "彰化市",
                            "code"=> "712701"
                        ),
                        array(
                            "name"=> "鹿港镇",
                            "code"=> "712721"
                        ),
                        array(
                            "name"=> "和美镇",
                            "code"=> "712722"
                        ),
                        array(
                            "name"=> "线西乡",
                            "code"=> "712723"
                        ),
                        array(
                            "name"=> "伸港乡",
                            "code"=> "712724"
                        ),
                        array(
                            "name"=> "福兴乡",
                            "code"=> "712725"
                        ),
                        array(
                            "name"=> "秀水乡",
                            "code"=> "712726"
                        ),
                        array(
                            "name"=> "花坛乡",
                            "code"=> "712727"
                        ),
                        array(
                            "name"=> "芬园乡",
                            "code"=> "712728"
                        ),
                        array(
                            "name"=> "员林镇",
                            "code"=> "712729"
                        ),
                        array(
                            "name"=> "溪湖镇",
                            "code"=> "712730"
                        ),
                        array(
                            "name"=> "田中镇",
                            "code"=> "712731"
                        ),
                        array(
                            "name"=> "大村乡",
                            "code"=> "712732"
                        ),
                        array(
                            "name"=> "埔盐乡",
                            "code"=> "712733"
                        ),
                        array(
                            "name"=> "埔心乡",
                            "code"=> "712734"
                        ),
                        array(
                            "name"=> "永靖乡",
                            "code"=> "712735"
                        ),
                        array(
                            "name"=> "社头乡",
                            "code"=> "712736"
                        ),
                        array(
                            "name"=> "二水乡",
                            "code"=> "712737"
                        ),
                        array(
                            "name"=> "北斗镇",
                            "code"=> "712738"
                        ),
                        array(
                            "name"=> "二林镇",
                            "code"=> "712739"
                        ),
                        array(
                            "name"=> "田尾乡",
                            "code"=> "712740"
                        ),
                        array(
                            "name"=> "埤头乡",
                            "code"=> "712741"
                        ),
                        array(
                            "name"=> "芳苑乡",
                            "code"=> "712742"
                        ),
                        array(
                            "name"=> "大城乡",
                            "code"=> "712743"
                        ),
                        array(
                            "name"=> "竹塘乡",
                            "code"=> "712744"
                        ),
                        array(
                            "name"=> "溪州乡",
                            "code"=> "712745"
                        )
                    ]
                ),
                array(
                    "name"=> "南投县",
                    "code"=> "712800",
                    "sub"=> [
                        array(
                            "name"=> "南投市",
                            "code"=> "712801"
                        ),
                        array(
                            "name"=> "埔里镇",
                            "code"=> "712821"
                        ),
                        array(
                            "name"=> "草屯镇",
                            "code"=> "712822"
                        ),
                        array(
                            "name"=> "竹山镇",
                            "code"=> "712823"
                        ),
                        array(
                            "name"=> "集集镇",
                            "code"=> "712824"
                        ),
                        array(
                            "name"=> "名间乡",
                            "code"=> "712825"
                        ),
                        array(
                            "name"=> "鹿谷乡",
                            "code"=> "712826"
                        ),
                        array(
                            "name"=> "中寮乡",
                            "code"=> "712827"
                        ),
                        array(
                            "name"=> "鱼池乡",
                            "code"=> "712828"
                        ),
                        array(
                            "name"=> "国姓乡",
                            "code"=> "712829"
                        ),
                        array(
                            "name"=> "水里乡",
                            "code"=> "712830"
                        ),
                        array(
                            "name"=> "信义乡",
                            "code"=> "712831"
                        ),
                        array(
                            "name"=> "仁爱乡",
                            "code"=> "712832"
                        )
                    ]
                ),
                array(
                    "name"=> "云林县",
                    "code"=> "712900",
                    "sub"=> [
                        array(
                            "name"=> "斗六市",
                            "code"=> "712901"
                        ),
                        array(
                            "name"=> "斗南镇",
                            "code"=> "712921"
                        ),
                        array(
                            "name"=> "虎尾镇",
                            "code"=> "712922"
                        ),
                        array(
                            "name"=> "西螺镇",
                            "code"=> "712923"
                        ),
                        array(
                            "name"=> "土库镇",
                            "code"=> "712924"
                        ),
                        array(
                            "name"=> "北港镇",
                            "code"=> "712925"
                        ),
                        array(
                            "name"=> "古坑乡",
                            "code"=> "712926"
                        ),
                        array(
                            "name"=> "大埤乡",
                            "code"=> "712927"
                        ),
                        array(
                            "name"=> "莿桐乡",
                            "code"=> "712928"
                        ),
                        array(
                            "name"=> "林内乡",
                            "code"=> "712929"
                        ),
                        array(
                            "name"=> "二仑乡",
                            "code"=> "712930"
                        ),
                        array(
                            "name"=> "仑背乡",
                            "code"=> "712931"
                        ),
                        array(
                            "name"=> "麦寮乡",
                            "code"=> "712932"
                        ),
                        array(
                            "name"=> "东势乡",
                            "code"=> "712933"
                        ),
                        array(
                            "name"=> "褒忠乡",
                            "code"=> "712934"
                        ),
                        array(
                            "name"=> "台西乡",
                            "code"=> "712935"
                        ),
                        array(
                            "name"=> "元长乡",
                            "code"=> "712936"
                        ),
                        array(
                            "name"=> "四湖乡",
                            "code"=> "712937"
                        ),
                        array(
                            "name"=> "口湖乡",
                            "code"=> "712938"
                        ),
                        array(
                            "name"=> "水林乡",
                            "code"=> "712939"
                        )
                    ]
                ),
                array(
                    "name"=> "嘉义县",
                    "code"=> "713000",
                    "sub"=> [
                        array(
                            "name"=> "太保市",
                            "code"=> "713001"
                        ),
                        array(
                            "name"=> "朴子市",
                            "code"=> "713002"
                        ),
                        array(
                            "name"=> "布袋镇",
                            "code"=> "713023"
                        ),
                        array(
                            "name"=> "大林镇",
                            "code"=> "713024"
                        ),
                        array(
                            "name"=> "民雄乡",
                            "code"=> "713025"
                        ),
                        array(
                            "name"=> "溪口乡",
                            "code"=> "713026"
                        ),
                        array(
                            "name"=> "新港乡",
                            "code"=> "713027"
                        ),
                        array(
                            "name"=> "六脚乡",
                            "code"=> "713028"
                        ),
                        array(
                            "name"=> "东石乡",
                            "code"=> "713029"
                        ),
                        array(
                            "name"=> "义竹乡",
                            "code"=> "713030"
                        ),
                        array(
                            "name"=> "鹿草乡",
                            "code"=> "713031"
                        ),
                        array(
                            "name"=> "水上乡",
                            "code"=> "713032"
                        ),
                        array(
                            "name"=> "中埔乡",
                            "code"=> "713033"
                        ),
                        array(
                            "name"=> "竹崎乡",
                            "code"=> "713034"
                        ),
                        array(
                            "name"=> "梅山乡",
                            "code"=> "713035"
                        ),
                        array(
                            "name"=> "番路乡",
                            "code"=> "713036"
                        ),
                        array(
                            "name"=> "大埔乡",
                            "code"=> "713037"
                        ),
                        array(
                            "name"=> "阿里山乡",
                            "code"=> "713038"
                        )
                    ]
                ),
                array(
                    "name"=> "屏东县",
                    "code"=> "713300",
                    "sub"=> [
                        array(
                            "name"=> "屏东市",
                            "code"=> "713301"
                        ),
                        array(
                            "name"=> "潮州镇",
                            "code"=> "713321"
                        ),
                        array(
                            "name"=> "东港镇",
                            "code"=> "713322"
                        ),
                        array(
                            "name"=> "恒春镇",
                            "code"=> "713323"
                        ),
                        array(
                            "name"=> "万丹乡",
                            "code"=> "713324"
                        ),
                        array(
                            "name"=> "长治乡",
                            "code"=> "713325"
                        ),
                        array(
                            "name"=> "麟洛乡",
                            "code"=> "713326"
                        ),
                        array(
                            "name"=> "九如乡",
                            "code"=> "713327"
                        ),
                        array(
                            "name"=> "里港乡",
                            "code"=> "713328"
                        ),
                        array(
                            "name"=> "盐埔乡",
                            "code"=> "713329"
                        ),
                        array(
                            "name"=> "高树乡",
                            "code"=> "713330"
                        ),
                        array(
                            "name"=> "万峦乡",
                            "code"=> "713331"
                        ),
                        array(
                            "name"=> "内埔乡",
                            "code"=> "713332"
                        ),
                        array(
                            "name"=> "竹田乡",
                            "code"=> "713333"
                        ),
                        array(
                            "name"=> "新埤乡",
                            "code"=> "713334"
                        ),
                        array(
                            "name"=> "枋寮乡",
                            "code"=> "713335"
                        ),
                        array(
                            "name"=> "新园乡",
                            "code"=> "713336"
                        ),
                        array(
                            "name"=> "崁顶乡",
                            "code"=> "713337"
                        ),
                        array(
                            "name"=> "林边乡",
                            "code"=> "713338"
                        ),
                        array(
                            "name"=> "南州乡",
                            "code"=> "713339"
                        ),
                        array(
                            "name"=> "佳冬乡",
                            "code"=> "713340"
                        ),
                        array(
                            "name"=> "琉球乡",
                            "code"=> "713341"
                        ),
                        array(
                            "name"=> "车城乡",
                            "code"=> "713342"
                        ),
                        array(
                            "name"=> "满州乡",
                            "code"=> "713343"
                        ),
                        array(
                            "name"=> "枋山乡",
                            "code"=> "713344"
                        ),
                        array(
                            "name"=> "三地门乡",
                            "code"=> "713345"
                        ),
                        array(
                            "name"=> "雾台乡",
                            "code"=> "713346"
                        ),
                        array(
                            "name"=> "玛家乡",
                            "code"=> "713347"
                        ),
                        array(
                            "name"=> "泰武乡",
                            "code"=> "713348"
                        ),
                        array(
                            "name"=> "来义乡",
                            "code"=> "713349"
                        ),
                        array(
                            "name"=> "春日乡",
                            "code"=> "713350"
                        ),
                        array(
                            "name"=> "狮子乡",
                            "code"=> "713351"
                        ),
                        array(
                            "name"=> "牡丹乡",
                            "code"=> "713352"
                        )
                    ]
                ),
                array(
                    "name"=> "台东县",
                    "code"=> "713400",
                    "sub"=> [
                        array(
                            "name"=> "台东市",
                            "code"=> "713401"
                        ),
                        array(
                            "name"=> "成功镇",
                            "code"=> "713421"
                        ),
                        array(
                            "name"=> "关山镇",
                            "code"=> "713422"
                        ),
                        array(
                            "name"=> "卑南乡",
                            "code"=> "713423"
                        ),
                        array(
                            "name"=> "鹿野乡",
                            "code"=> "713424"
                        ),
                        array(
                            "name"=> "池上乡",
                            "code"=> "713425"
                        ),
                        array(
                            "name"=> "东河乡",
                            "code"=> "713426"
                        ),
                        array(
                            "name"=> "长滨乡",
                            "code"=> "713427"
                        ),
                        array(
                            "name"=> "太麻里乡",
                            "code"=> "713428"
                        ),
                        array(
                            "name"=> "大武乡",
                            "code"=> "713429"
                        ),
                        array(
                            "name"=> "绿岛乡",
                            "code"=> "713430"
                        ),
                        array(
                            "name"=> "海端乡",
                            "code"=> "713431"
                        ),
                        array(
                            "name"=> "延平乡",
                            "code"=> "713432"
                        ),
                        array(
                            "name"=> "金峰乡",
                            "code"=> "713433"
                        ),
                        array(
                            "name"=> "达仁乡",
                            "code"=> "713434"
                        ),
                        array(
                            "name"=> "兰屿乡",
                            "code"=> "713435"
                        )
                    ]
                ),
                array(
                    "name"=> "花莲县",
                    "code"=> "713500",
                    "sub"=> [
                        array(
                            "name"=> "花莲市",
                            "code"=> "713501"
                        ),
                        array(
                            "name"=> "凤林镇",
                            "code"=> "713521"
                        ),
                        array(
                            "name"=> "玉里镇",
                            "code"=> "713522"
                        ),
                        array(
                            "name"=> "新城乡",
                            "code"=> "713523"
                        ),
                        array(
                            "name"=> "吉安乡",
                            "code"=> "713524"
                        ),
                        array(
                            "name"=> "寿丰乡",
                            "code"=> "713525"
                        ),
                        array(
                            "name"=> "光复乡",
                            "code"=> "713526"
                        ),
                        array(
                            "name"=> "丰滨乡",
                            "code"=> "713527"
                        ),
                        array(
                            "name"=> "瑞穗乡",
                            "code"=> "713528"
                        ),
                        array(
                            "name"=> "富里乡",
                            "code"=> "713529"
                        ),
                        array(
                            "name"=> "秀林乡",
                            "code"=> "713530"
                        ),
                        array(
                            "name"=> "万荣乡",
                            "code"=> "713531"
                        ),
                        array(
                            "name"=> "卓溪乡",
                            "code"=> "713532"
                        )
                    ]
                ),
                array(
                    "name"=> "澎湖县",
                    "code"=> "713600",
                    "sub"=> [
                        array(
                            "name"=> "马公市",
                            "code"=> "713601"
                        ),
                        array(
                            "name"=> "湖西乡",
                            "code"=> "713621"
                        ),
                        array(
                            "name"=> "白沙乡",
                            "code"=> "713622"
                        ),
                        array(
                            "name"=> "西屿乡",
                            "code"=> "713623"
                        ),
                        array(
                            "name"=> "望安乡",
                            "code"=> "713624"
                        ),
                        array(
                            "name"=> "七美乡",
                            "code"=> "713625"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "香港特别行政区",
            "code"=> "810000",
            "sub"=> [
                array(
                    "name"=> "香港岛",
                    "code"=> "810100",
                    "sub"=> [
                        array(
                            "name"=> "中西区",
                            "code"=> "810101"
                        ),
                        array(
                            "name"=> "湾仔区",
                            "code"=> "810102"
                        ),
                        array(
                            "name"=> "东区",
                            "code"=> "810103"
                        ),
                        array(
                            "name"=> "南区",
                            "code"=> "810104"
                        )
                    ]
                ),
                array(
                    "name"=> "九龙",
                    "code"=> "810200",
                    "sub"=> [
                        array(
                            "name"=> "油尖旺区",
                            "code"=> "810201"
                        ),
                        array(
                            "name"=> "深水埗区",
                            "code"=> "810202"
                        ),
                        array(
                            "name"=> "九龙城区",
                            "code"=> "810203"
                        ),
                        array(
                            "name"=> "黄大仙区",
                            "code"=> "810204"
                        ),
                        array(
                            "name"=> "观塘区",
                            "code"=> "810205"
                        )
                    ]
                ),
                array(
                    "name"=> "新界",
                    "code"=> "810300",
                    "sub"=> [
                        array(
                            "name"=> "荃湾区",
                            "code"=> "810301"
                        ),
                        array(
                            "name"=> "屯门区",
                            "code"=> "810302"
                        ),
                        array(
                            "name"=> "元朗区",
                            "code"=> "810303"
                        ),
                        array(
                            "name"=> "北区",
                            "code"=> "810304"
                        ),
                        array(
                            "name"=> "大埔区",
                            "code"=> "810305"
                        ),
                        array(
                            "name"=> "西贡区",
                            "code"=> "810306"
                        ),
                        array(
                            "name"=> "沙田区",
                            "code"=> "810307"
                        ),
                        array(
                            "name"=> "葵青区",
                            "code"=> "810308"
                        ),
                        array(
                            "name"=> "离岛区",
                            "code"=> "810309"
                        )
                    ]
                )
            ]
        ),
        array(
            "name"=> "澳门特别行政区",
            "code"=> "820000",
            "sub"=> [
                array(
                    "name"=> "澳门半岛",
                    "code"=> "820100",
                    "sub"=> [
                        array(
                            "name"=> "花地玛堂区",
                            "code"=> "820101"
                        ),
                        array(
                            "name"=> "圣安多尼堂区",
                            "code"=> "820102"
                        ),
                        array(
                            "name"=> "大堂区",
                            "code"=> "820103"
                        ),
                        array(
                            "name"=> "望德堂区",
                            "code"=> "820104"
                        ),
                        array(
                            "name"=> "风顺堂区",
                            "code"=> "820105"
                        )
                    ]
                ),
                array(
                    "name"=> "氹仔岛",
                    "code"=> "820200",
                    "sub"=> [
                        array(
                            "name"=> "嘉模堂区",
                            "code"=> "820201"
                        )
                    ]
                ),
                array(
                    "name"=> "路环岛",
                    "code"=> "820300",
                    "sub"=> [
                        array(
                            "name"=> "圣方济各堂区",
                            "code"=> "820301"
                        )
                    ]
                )
            ]
        )

        ];
        $province = array();
        $city = array();
        $county = array();
        foreach ($city_str as $value) {
            $province_id = $value['code'];
            $p_item = [];
            $p_item['province_name'] = $value['name'];
            $p_item['province_id'] = $province_id;
            $province[]=$p_item;
            
            if(isset($value['sub']) && !empty($value['sub'])){
                foreach ($value['sub'] as $val) {
                    $city_id = $val['code'];
                    $c_item = [];
                    $c_item['city_name'] = $val['name'];
                    $c_item['city_id'] = $city_id;
                    $c_item['province_id'] = $province_id;
                    $city[]=$c_item;
                    
                    if(isset($val['sub']) && !empty($val['sub'])){
                        foreach ($val['sub'] as $v) {
                            $u_item = [];
                            $u_item['county_name'] = $v['name'];
                            $u_item['county_id'] = $v['code'];
                            $u_item['city_id'] = $city_id;
                            $county[]=$u_item;
                        }
                    }
                    
                }
            }
            
        }
//        debug($province);
        try {
            $res_province = D("Province")->addAll($province);

            if(empty($res_province)){
                throw new Exception('省份导入失败');
            }
//            debug($city);
//            debug($county);
            $res_city = D("City")->addAll($city);
//            debug(D()->getLastSql());
            if(empty($res_city)){
                throw new Exception('城市导入失败');
            }
            $res_county = D("County")->addAll($county);
            if(empty($res_county)){
                throw new Exception('市区导入失败');
            }
            
            echo '导入成功';
           
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        
    }
}