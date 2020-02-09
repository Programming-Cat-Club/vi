{include header}
<div class="wrapper">
    {include header_menu}

    {include left_menu}
    <div class="main-container">
        <div class="padding-md">
            <h2 class="header-text no-margin">
                分类管理
            </h2>
            <div class="gallery-filter m-top-md m-bottom-md">
                <ul class="clearfix">
                    <li class="active"><a href="javascript:void(0)" data-toggle="modal" data-target="#normalModal"><i class="fa fa-plus"></i> 增加分类</a></li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered m-top-md" id="dataTable" >
                    <thead>
                        <tr class="bg-dark-blue">
                            <th>#</th>
                            <th>名称</th>
                            <th>操作</th>
    
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $data as $v}
                        <tr>
                            <td>{$v.id}</td>
                            <td>{$v.name}</td>
                            <td><button class="btn btn-info btn-sm" data-toggle="modal"  data-target="#normalModal_edit"
                                data-whatever='{"id":"{$v.id}","name":"{$v.name}"}'>编辑</button><button class="btn btn-danger btn-sm">删除</button></td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
                
            </div>

        </div><!-- ENd box  -->

    </div>

<!-- Modal -->
    <form method="post">
    <div class="modal fade" id="normalModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加分类</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="gn" value="add">
                    <div class="form-group">
                        <label for="">分类名称</label>
                        <input type="text" name="gname" class="form-control" value="">
                        <span>分组名称</span>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- edit -->
    <form method="post">
    <div class="modal fade" id="normalModal_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加分类</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="gn" value="edit">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="">分类名称</label>
                        <input type="text" name="gname" class="form-control" value="">
                        <span>分组名称</span>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </div>
    </div>
    </form>

 
    <!-- !Modal -->
{include footer}

<script>
    $('#normalModal_edit').on('show.bs.modal', function (event) {
        let codehtml = '';
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="gname"]').val(recipient.name)
        modal.find('.modal-body input[name="id"]').val(recipient.id)
    })
</script>