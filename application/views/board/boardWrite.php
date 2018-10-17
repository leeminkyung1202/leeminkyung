<?php
	if(empty($idx)) {
		$actionGo 	= "/board/boardWrite";
		$actionTxt 	= "등록";
	} else {
		$actionGo 	= "/board/boardSave/".$idx.$dataView['paginNo'];
		$actionTxt 	= "저장";
    }
?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <!-- 상단 :: STR -->
        <div class="x_title">
            <h2>Table<small>기본 테이블</small></h2>
            <div class="clearfix"></div>
        </div><!-- //x_title -->
        <!-- 상단 :: END -->

        <div class="x_content">
            <form action="<?=$actionGo?>" id="boardForm" method="post" name="writeForm">
                <input type="hidden" name="idx" value="<?=$idx?>" />
                <table id="boardWrite" class="table">
                    <colgroup>
                        <col width="10%" />
                        <col width="*" />
                    </colgroup>
                    <tr>
                        <th>제목</th>
                        <td><input type="text" name="title" required="required" value="<?=$dataView['list']['title']?>" class="form-control col-md-7 col-xs-12" /></td>
                    </tr>
                    <tr>
                        <th>내용</th>
                        <td><textarea name='content' rows='2'><?=$dataView['list']['content']?></textarea></td>
                    </tr>
                </table><!-- //boardWrite -->
                <a href="/board/board"><button type="button" class="btn btn-default">목록</button></a>
                <button type="submit" class="btn btn-info"><?=$actionTxt?></button>
            </form>
        </div><!-- //x_content -->
    </div><!-- //x_panel -->
</div><!-- //col-md-12 -->