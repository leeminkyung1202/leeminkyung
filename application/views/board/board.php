<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <!-- 상단 :: STR -->
        <div class="x_title">
            <h2>Table<small>기본 테이블</small></h2>

            <!-- 검색 :: STR -->
            <form name="seatchForm" method="get" action="/board/board">
                <div>
                    <select name="seatchTitle">
                        <option value="title" <?=('title' == $dataView['searchGet']['seatchTitle'])? "selected" : "" ?> >제목</option>
                        <option value="content" <?=('content' == $dataView['searchGet']['seatchTitle'])? "selected" : "" ?> >내용</option>
                    </select>
                    <input type="text" name="keyWord" value="<?=$dataView['searchGet']['keyWord']?>" placeholder="제목 검색">
                    <span>
                        <button type="submit">Go!</button>
                        <button type="submit" id="cancelBtn">No!</button>
                    </span>
                </div>
            </form>
            <!-- 검색 :: END -->

            <div class="clearfix"></div>
        </div><!-- //x_title -->
        <!-- 상단 :: END -->

        <div class="x_content">
            <a href="/board/boardWrite"><button type="button" class="btn btn-success">작성하기</button></a>

            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <colgroup>
                        <col width="10%" />
                        <col width="*" />
                        <col width="10%" />
                        <col width="10%" />
                        <col width="20%" />
                    </colgroup>
                    <thead>
                    <tr class="headings">
                        <th class="column-title">No</th>
                        <th class="column-title">제목</th>
                        <th class="column-title">작성자</th>
                        <th class="column-title">조회수</th>
                        <th class="column-title">날짜</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($dataView['list'] as $data){ ?>
                        <tr class="even pointer">
                            <td><?=$dataView['num']?></td>
                            <td><a href="/board/boardView/<?=$data['idx']?><?=$dataView['paginGet']?>"><?=$data['title']?></a></td>
                            <td><?=$data['name']?></td>
                            <td><?=$data['hits']?></td>
                            <td><?=$data['regdate']?></td>
                        </tr>
                        <?php
                        $dataView['num'] --;
                    }
                    ?>
                    </tbody>
                </table>

                <!-- 페이징 :: STR -->
                <div id="pagination">
                    <p><?=$dataView['pagination']?></p>
                </div><!-- //pagination -->
                <!-- 페이징 :: END -->

            </div><!-- //table-responsive -->
        </div><!-- //x_content -->
    </div><!-- //x_panel -->
</div><!-- //col-md-12 -->

<script>
    // 검색취소
    var url = '/board/board';

    $('#cancelBtn').on('click',function(){
        window.location.href = url ;
        return false;
    });
</script>