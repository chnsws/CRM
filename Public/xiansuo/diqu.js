window.diqujsload='1';
function get_diqu1()
{
    var a=''
    for(b in Area)
    {
        Area[b]['provinceName']//省名
        Area[b]['provinceCode']//省id
        a+="<option value='"+Area[b]['provinceCode']+"'>"+Area[b]['provinceName']+"</option>";
    }
    return a;
}
function get_diqu2(sheng_id)
{
    var a='';
    if(sheng_id!='0')
    {
        for(b in Area)
        {
            if(Area[b]['provinceCode']==sheng_id)
            {
                var shi=Area[b]['mallCityList'];
                for(c in shi)
                {
                    a+="<option value='"+shi[c]['cityCode']+"'>"+shi[c]['cityName']+"</option>";
                }
            }
        }
    }
    else
    {
        var shi=Area[0]["mallCityList"]
        for(c in shi)
        {
            a+="<option value='"+shi[c]['cityCode']+"'>"+shi[c]['cityName']+"</option>";
        }
    }
    return a;
}
function get_diqu3(sheng_id,shi_id)
{
    var a='';
    if(sheng_id!='0')
    {
        for(b in Area)
        {
            if(Area[b]['provinceCode']==sheng_id)
            {
                var shi=Area[b]['mallCityList'];
                if(shi_id!='0')
                {
                    for(c in shi)
                    {
                        if(shi[c]['cityCode']==shi_id)
                        {
                            var qu=shi[c]["mallAreaList"];
                            for(d in qu)
                            {
                                a+="<option value='"+qu[d]['areaCode']+"'>"+qu[d]['areaName']+"</option>";
                            }
                        }
                    }
                }
                else
                {
                    var qu=shi[0]["mallAreaList"];
                    for(d in qu)
                    {
                        a+="<option value='"+qu[d]['areaCode']+"'>"+qu[d]['areaName']+"</option>";
                    }
                }
            }
        }
    }
    else
    {
        var qu=Area[0]["mallCityList"][0]["mallAreaList"];
        for(d in qu)
        {
            a+="<option value='"+qu[d]['areaCode']+"'>"+qu[d]['areaName']+"</option>";
        }
    }
    return a;
}