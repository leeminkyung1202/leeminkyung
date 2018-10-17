<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <!-- 상단 :: STR -->
        <div class="x_title">
            <h2>Table<small>기본 테이블</small></h2>
            
            <div class="clearfix"></div>
        </div><!-- //x_title -->
        <!-- 상단 :: END -->

        <div class="x_content">
            <a href="/editor/editorDaum"><button type="button" class="btn btn-success">다음 에디터<br/>작성하기</button></a>
            <a href="/editor/editorNaver"><button type="button" class="btn btn-success">네이버 에디터<br/>작성하기</button></a>
            <a href="/editor/editorCk"><button type="button" class="btn btn-success">CK 에디터<br/>작성하기</button></a>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">                 
                    <colgroup>
                        <col width="10%" />
                        <col width="*" />
                    </colgroup>
                    <thead>
                        <tr class="headings">
                            <th class="column-title">에디터 종류</th>
                            <th class="column-title">내용</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php foreach($list as $data){ ?>
                        <tr class="even pointer">
                            <td><?=$data['editor']?></td>
                            <td><?=$data['content']?></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>

            </div><!-- //table-responsive -->
        </div><!-- //x_content -->
    </div><!-- //x_panel -->
</div><!-- //col-md-12 -->
