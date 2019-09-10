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
                            @foreach($product->attributes as $attribute)
                                    @if($attribute->has_children)
                                        <tr>
                                            <td rowspan="{{ $attribute->getChildren->count() }}" width="163" height="36"><span class="item-product">{{ $attribute->attribute }}</span></td>
                                            <td width="300" height="36"><span class="item-product">{{ $attribute->getChildren->first()->child_value }}</span></td>
                                            <td width="300" height="36"><span class="item-product">{{ $attribute->getChildren->first()->child_description }}</span></td>
                                        </tr>
                                        @foreach($attribute->getChildren->splice(1) as $child)
                                            <tr>
                                                <td width="300" height="36"><span class="item-product">{{ $child->child_value }}</span></td>
                                                <td width="300" height="36"><span class="item-product">{{ $child->child_description }}</span></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td width="163" height="36"><span class="item-product">{{ $attribute->attribute }}</span></td>
                                            <td width="300" height="36"><span class="item-product">{{ $attribute->attribute_value }}</span></td>
                                            <td width="300" height="36"><span class="item-product">{{ $attribute->attribute_description }}</span></td>
                                        </tr>
                                    @endif
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

