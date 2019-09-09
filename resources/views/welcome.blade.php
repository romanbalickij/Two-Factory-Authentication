@extends('layouts.app')
@section('content')
    <div class="page_container">
        <div class="main_content ">
            <div id="shopify-section-template-product" class="shopify-section section section_single-product section_product section_template__product">
                <div class="container">
                    <div class="row">
                        <div class="single_product__img col-lg-6">
                            <div class="slider-for gallery clearfix">

                                    <a rel="prettyPhoto[gallery1]"  href="" class="item">
                                        <img  src="" alt=""  draggable="false"/>
                                    </a>

                            </div>
                            <div class="slider-nav">

                                    <div class="item">
                                        <img class="image-link" src="" alt=""  draggable="false"/>
                                    </div>

                            </div>
                        </div>
                        <div class="single_product__info col-lg-6 medium">
                            <h2 class="single_product__title"></h2>
                            <div class="single_product__details">
                                <div class="clearfix"></div>
                                <div class="details_separator"></div>
                                <div class="details_wrapper">
                                    <div class="details_left">
                                        <div class="section-contents">
                                            <div class="products-content">Розміри:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Вага:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Колір:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Пульт управління:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Напруга:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Тиск води:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Постачання води:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Довжина електричного шнура:</div>
                                            <div class="products-content products-content-discription"></div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Гарантія:</div>
                                            <div class="products-content products-content-discription">12 місяців з дати встановлення.</div>
                                        </div>
                                        <div class="section-contents">
                                            <div class="products-content">Ціна:</div>
                                            <div class="products-content products-content-discription">грн.</div>
                                        </div>
                                        <div class="section-contents"><div class="products-content" >Якщо Вас зацікавив продукт :</div>
                                            <div class="" >
                                                <!-- Trigger the modal with a button -->
                                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" >Зворотній зв'язок</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_description table-responsive rte">
                        <table class="table-product" >
                            <colgroup>
                                <col width="163" />
                                <col width="300" />
                                <col width="300" /> </colgroup>
                            <tbody>
                            <tr>
                                <td colspan="2" class="item-title" width="326" height="62"><span class="item-product ">Специфікація</span></td>
                                <td width="300" class="item-title"  height="62"><span class="item-product ">Опис функції</span></td>
                            </tr>
                            <tr>
                                <td width="163" height="36"><span class="item-product">Напруга (attribute)</span></td>
                                <td width="300" height="36"><span class="item-product">(attribute_value) 220-240V 50Hz/60Hz оптимальний</span></td>
                                <td width="300" height="36"><span class="item-product">(attribute_value descriptions) Сидіння з підігрівом та регулюванням температури</span></td>
                            </tr>
                            <tr>
                                <td width="163" height="26"><span class="item-product">Постачання води</span></td>
                                <td width="300" height="26"><span class="item-product">(attribute_value) пряме підключення до водопровідної труби</span></td>
                                <td width="300" height="26"><span class="item-product">(attribute_value descriptions) Вода нагрівається і регулюється температура</span></td>
                            </tr>
                            <tr>
                                <td width="163" height="26"><span class="item-product">Тиск води </span></td>
                                <td width="300" height="26"><span class="item-product">Рухливий масаж - переміщення розпилення (вперед і назад)</span></td>
                                <td width="300" height="26"><span class="item-product">0.08-0.75 Mпа</span></td>
                            </tr>
                            <tr>
                                <td rowspan="4" width="163" height="135"><span class="item-product">Тепле миття</span></td>
                                <td width="300" height="26"><span class="item-product"> (attribute) - регулятор тиску води регулюється</span></td>
                                <td width="300" height="26"><span class="item-product">(attribute_value descriptions)Тепле сушіння повітря та регулювання температури повітря</span></td>
                            </tr>
                            <tr>
                                <td width="300" height="57"><span class="item-product">Контроль температури (4 ступені, кімнатна температура / 33 ° C / 38 ° C / 42 ° C регульована)</span></td>
                                <td width="300" height="57"><span class="item-product">Самоочищаюча форсунка</span></td>
                            </tr>
                            <tr>
                                <td width="300" height="26"><span class="item-product">Потужність обігрівача: 1350 Вт</span></td>
                                <td width="300" height="26"><span class="item-product">Регулюється позиція насадки</span></td>
                            </tr>
                            <tr>
                                <td width="300" height="26"><span class="item-product">Ємність баку : 1Л</span></td>
                                <td width="300" height="26"><span class="item-product">Регулюється тиск води</span></td>
                            </tr>
                            <tr>
                                <td rowspan="2" width="163" height="75"><span class="item-product">Тепла повітряна сушарка</span></td>
                                <td width="300" height="26"><span class="item-product"> attribute - Тепла повітряна сушарка</span></td>
                                <td width="300" height="26"><span class="item-product"> descriptions Потужність : 250W </span></td>
                            </tr>
                            <tr>
                                <td width="300" height="49"><span class="item-product">Контроль температури (4 ступені, кімнатна температура / 45 ° C / 50 ° C / 55 ° C регульована)</span></td>
                                <td width="300" height="49"><span class="item-product">Вмонтований автоматичний датчик тіла</span></td>
                            </tr>
                            <tr>
                                <td rowspan="3" width="163" height="109"><span class="item-product">Тепле місце</span></td>
                                <td width="300" height="26"><span class="item-product">Потужність : 50W</span></td>
                                <td width="300" height="26"><span class="item-product">Встановлений термостат</span></td>
                            </tr>
                            <tr>
                                <td width="300" height="26"><span class="item-product">м'яка закриваюча конструкція кришки</span></td>
                                <td width="300" height="26"><span class="item-product">Кришка біде та сидіння мають амортизатор (закривання відбувається плавно і тихо)</span></td>
                            </tr>
                            <tr>
                                <td width="300" height="57"><span class="item-product">Контроль температури (4 ступені, кімнатна температура / 30 ° C / 35 ° C / 40 ° C регульована)</span></td>
                                <td width="300" height="57"><span class="item-product">Для поглинання запаху дезодорування з бамбукового вугілля</span></td>
                            </tr>
                            <tr>
                                <td width="163" height="26"><span class="item-product">Довжина електричного шнура</span></td>
                                <td width="300" height="26"><span class="item-product">1.5 м</span></td>
                                <td width="300" height="26"><span class="item-product">Інтелектуальний режим енергозбереження</span></td>
                            </tr>
                            <tr>
                                <td width="163" height="61"><span class="item-product">Запобіжник</span></td>
                                <td width="300" height="61"><span class="item-product">плаваючий вимикач, датчик температури, запобіжник температури, заземлення</span></td>
                                <td width="300" height="61"><span class="item-product">Жіноча промивка (біде)</span></td>
                            </tr>

                                <tr>
                                    <td width="163" height="26"><span class="item-product">Метод промивання</span></td>
                                    <td width="300" height="26"><span class="item-product">Циклами</span></td>
                                    <td width="300" height="26"><span class="item-product"></span></td>
                                </tr>


                                <tr>
                                    <td width="163" height="26"><span class="item-product">Проливний обєм</span></td>
                                    <td width="300" height="26"><span class="item-product">4,5 л</span></td>
                                    <td width="300" height="26"><span class="item-product">Відсутній водяний бак</span></td>
                                </tr>


                                <tr>
                                    <td width="163" height="26"><span class="item-product">Відстань до стіни</span></td>
                                    <td width="300" height="26"><span class="item-product">	300 мм / 400 мм</span></td>
                                    <td width="300" height="26"><span class="item-product">Повітряний душ</span></td>
                                </tr>

                            <tr>
                                <td width="163" height="26"><span class="item-product">Вага</span></td>
                                <td width="300" height="26"><span class="item-product">N.W. 40 кг G.W. 42 кг</span></td>
                                <td width="300" height="26"><span class="item-product">Промивка в зоні ягодиць</span></td>
                            </tr>
                            <tr>
                                <td rowspan="2" width="163" height="56"><span class="item-product">Розміри</span></td>
                                <td rowspan="2" width="300" height="56"><span class="item-product">745мм*410мм*550мм</span></td>
                                <td width="300" height="26"><span class="item-product">Автоматичні функції -Плавно герметизується, щоб допомогти очищенню/span></td>
                            </tr>
                            <tr>
                                <td width="300" height="30"><span class="item-product"></span></td>
                            </tr>

                                <tr>
                                    <td width="163" height="26"><span class="item-product">Колір</span></td>
                                    <td width="300" height="26"><span class="item-product">Білий</span></td>
                                    <td width="300" height="26"><span class="item-product">Титанове сопло (насадка)</span></td>
                                </tr>


                                <tr>
                                    <td width="163" height="26"><span class="item-product">Підсвітка</span></td>
                                    <td width="300" height="26"><span class="item-product"></span></td>
                                    <td width="300" height="26"><span class="item-product"></span></td>
                                </tr>

                            <tr>
                                <td width="163" height="26"><span class="item-product">Пульт управління</span></td>
                                <td width="300" height="26"><span class="item-product"></span></td>
                                <td width="300" height="26"><span class="item-product">Дитячі функції</span></td>
                            </tr>
                            <tr>
                                <td rowspan="2" width="163" height="56"><span class="item-product"></span></td>
                                <td rowspan="2" width="300" height="56"><span class="item-product"></span></td>
                                <td width="300" height="26"><span class="item-product"></span></td>
                            </tr>
                            <tr>
                                <td width="300" height="30"><span class="item-product"> </span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

