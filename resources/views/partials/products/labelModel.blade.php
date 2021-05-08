 <button class="btn btn-sm btn-secondary" title="Product Lable Printing" data-toggle="modal" data-target="#label" ><i class="fa fa-barcode fa-fw" aria-hidden="true"></i>{{__('common.label')}}</button>
            <!-- Modal -->
            <div class="modal fade" id="label" tabindex="-1" role="dialog" aria-labelledby="label" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header p-3 bg-secondary">
                    <h2 class="modal-title text-white pl-2"><i class="fa fa-barcode fa-lg fa-fw" aria-hidden="true"></i> {{__('manage.label.print.configuration')}} </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('product.label')}}" method="post">
                      {{csrf_field()}}
                      <div class="row mb-3">
                        <div class="from-group col-md-4">
                          <label> {{__('manage.enter.label.quantity')}}</label>
                          <input type="number" name="amount" min="1"  value="1" class="form-control" required="required" placeholder="100">
                          <input type="hidden" name="product_id" value="{{$item->id}}">
                        </div>
                        <div class="from-group col-md-4">
                          <label>{{__('manage.enter.font.size.extra.options')}}</label>
                          <input type="number" name="fontSize" class="form-control" value="11" placeholder="{{__('manage.enter.font.size.extra.options')}}" required>
                        </div>
                        <div class="from-group col-md-4">
                          <label> {{__('manage.barcode.symbology')}}</label>
                          <select class="form-control" name="symbology">
                            <option value="{{$item->barcode_symbology}}">{{__('manage.default')}}</option>
                            <option value="C128">C128</option>
                            <option value="C39+">C39+</option>
                            <option value="C39">C39</option>
                            <option value="C128A">C128A</option>
                            <option value="C39E">C39E</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <strong id="extraOption">{{__('manage.extra.options')}}</strong>
                          <table class="table table-bordered">
                            <caption>{{__('manage.extra.options')}}</caption>
                            <tr>
                              <th scope="row">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="price"  name="price" value="1" checked="checked">
                                  <label class="custom-control-label" for="price">{{__('manage.print.product.price')}}</label>
                                </div>
                              </th>
                              <th scope="row">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="code"  name="code" value="1">
                                  <label class="custom-control-label" for="code"> {{__('manage.print.product.code')}}</label>
                                </div>
                              </th>
                            </tr>
                            <tr>
                              <td>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="name"  name="name" value="1">
                                  <label class="custom-control-label" for="name">{{__('manage.print.product.name')}}</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="company"  name="company" value="1">
                                  <label class="custom-control-label" for="company">{{__('manage.print.company.name')}}</label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="border"  name="border" value="1">
                                  <label class="custom-control-label text-danger" for="border"> {{__('manage.print.label.with.border')}}</label>
                                </div>
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6" title="{{__('manage.rowLableTitle')}}" data-toggle="tooltip">
                              <label> {{__('manage.rows.label.blacks.division')}}</label>
                              <select class="form-control" name="col" id="col">
                                <option title="6 Labels in one row,width 16.7% of each" value="p-0 col-md-2 col-sm-2 ">6 Default</option>
                                <option title="12 Labels in one row, width 8.33% of each" value="p-0 col-md-1 col-sm-1 ">12  -  8.33%</option>
                                <option title="4 Labels in one row, width 25% of each" value="p-0 col-md-3 col-sm-3 ">4 - 25%</option>
                                <option title="3 Labels in one row, width 33.3% of each" value="p-0 col-md-4 col-sm-4 ">3  - 33.4% </option>
                                <option title="2 Labels in one row, width 41.7% of each" value="p-0 col-md-5 col-sm-5 ">2  - 41.7%</option>
                                <option title="2 Labels in one row, width 50% of each" value="p-0 col-md-6 col-sm-6 ">2 - 50%</option>
                                <option title="1 Label in one row with width 58.4%" value="p-0 col-md-7 col-sm-7 ">1 - 58.4%</option>
                                <option title="1 Label in one row with width 66.7%" value="p-0 col-md-8 col-sm-8 ">1 - 66.7%</option>
                                <option title="1 Label in one row with width 75%" value="p-0 col-md-9 col-sm-9 ">1 - 75%</option>
                                <option title="1 Label in one row with width 84.4%" value="p-0 col-md-10 col-sm-10 ">1 - 84.4%</option>
                                <option title="1 Label in one row with width 91.7%" value="p-0 col-md-11 col-sm-11 ">1 - 91.7%</option>
                                <option title="1 Label in one row with width 100%" value="p-0 col-md-12 col-sm-12" id="custom_inputs">1 - 100%</option>
                              </select>
                            </div>
                            <div class="col-md-6" title="{{__('manage.blackSpaceTitle')}}" data-toggle="tooltip">
                              <label>{{__('manage.block.spacing')}}</label>
                              <select class="form-control" name="padding">
                                <option value="p-1">1 Default</option>
                                <option value="p-0">0 </option>
                                <option value="p-2">2</option>
                                <option value="p-3">3</option>
                                <option value="p-4">4</option>
                                <option value="p-5">5</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-6" title="{{__('manage.insideBlockTitle')}}" data-toggle="tooltip">
                              <label class="mb-0">{{__('manage.label.height')}}</label>
                              <a href="#" title="{{__('manage.customHightTitle')}}"  data-toggle="tooltip"class="float-right" id="label_height"><i class="fa fa-plug" aria-hidden="true"></i></a>
                              <input type="number" name="height" min="1" placeholder="Height in pixel" class="form-control" id="label_height_input">
                              @include('./partials.products.labelSize',['name'=>'height','id'=>'label_height_options','default'=>'50'])
                            </div>
                            <div class="col-md-6"  title="{{__('manage.customWidthTitle')}}" data-toggle="tooltip">
                              <label>{{__('manage.label.width')}}</label>
                              <a href="#" title="{{__('manage.enterCutomeWidth')}}" data-toggle="tooltip" class="float-right" id="label_width"><i class="fa fa-plug" aria-hidden="true"></i></a>
                              <input type="number" name="width" min="1" placeholder="Width in pixel" class="form-control" id="label_width_input">
                              @include('./partials.products.labelSize',['name'=>'width','id'=>'label_width_options','default'=>'110'])
                            </div>
                          </div>
                        </div>
                      </div>
                      <button type="button" class="btn btn-sm pull-left" data-dismiss="modal">{{__('common.cancel')}}</button>
                      <button class="float-right btn btn-sm btn-secondary" type="submit">{{__('common.print')}}</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
