<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <!-- 상단 :: STR -->
        <div class="x_title">
            <h2>Table<small>기본 테이블</small></h2>
            <div class="clearfix"></div>
        </div><!-- //x_title -->
        <!-- 상단 :: END -->

        <div class="x_content">

            <!-- 좋아요/싫어요 :: STR -->
            <div>
                <a href="javascript:;" data-divide="like" class="btn btn-app mood">
                    <span class="badge bg-blue like"><?=$dataView["list"]["like"]?></span>
                    <i class="fa fa-heart-o"></i> 좋아요
                </a>
                <a href="javascript:;" data-divide="dislike" class="btn btn-app mood">
                    <span class="badge bg-red dislike"><?=$dataView["list"]["dislike"]?></span>
                    <i class="fa fa-hand-o-down"></i> 싫어요
                </a>
            </div>
            <!-- 좋아요/싫어요 :: END -->

            <table id="boardWrite" class="table">
                <colgroup>
                    <col width="10%" />
                    <col width="*" />
                </colgroup>
                <tr>
                    <th>제목</th>
                    <td><?=$dataView["list"]["title"]?></td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td><?=$dataView["list"]["content"]?></td>
                </tr>
            </table><!-- //boardWrite -->

            <div class="btnCenter">
                <a href="/board/board/<?=$dataView["paginGet"]?>"><button type="button" class="btn btn-default">목록</button></a>
                <a href="/board/boardWrite/<?=$idx?><?=$dataView["paginNo"]?>"><button type="button" class="btn btn-primary">수정</button></a>
                <a href="javascript:;" class="eventDelete" data-idx="<?=$idx?>" data-pagin="<?=$dataView["paginGet"]?>"><button type="button" class="btn btn-danger">삭제</button></a>
            </div><!-- //btnCenter -->

            <!-- 댓글 :: STR -->
            <form name="comment" id="commentForm" method="post" action="/board/commentWrite/<?=$idx?><?=$dataView['paginNo']?>">
                <input type="hidden" name="idx" value="<?=$idx?>" />
                
                <textarea name="content" rows="2" placeholder="댓글을 입력하세요."></textarea>
                <span class="btn">
                    <button type="submit" class="btn btn-info">등록</button>
                </span><!-- //btn -->
            </form>
            
            <ul class="commentList">
                <?php 
                    foreach($dataView['commentList'] as $comment){
                        $styleM = $comment['groupLayer']*20;
                ?>
                <li data-idxcom="<?=$comment['idx']?>" data-orgno="<?=$comment['originNo']?>" style="margin-left:<?=$styleM?>px;">
                    <div class="profile">
                        <img src="/gentelella-master/production/images/hm1031.jpg" alt="프로필 이미지" />
                    </div><!-- //profile -->

                    <div class="content">
                        <div class="name">
                            <span><?=$comment['name']?></span>
                            <a href="javascript:;" class="commentDelete"><i class="fa fa-trash"></i></a> <!-- 삭제 -->
                            <a href="javascript:;" class="commentSave"><i class="fa fa-pencil"></i></a> <!-- 수정 -->
                            <a href="javascript:;" class="commentAdd">답글달기</a>
                        </div><!-- //name -->

                        <span class="message" data-con="<?=$comment['content']?>">
                            <b class="title"></b><?=$comment['content']?>
                        </span>
                    </div><!-- //content -->

                    <div class="timeLike">
                        <span class="time"><?=$comment['regdate']?></span>

                        <a href="javascript:;" data-divide="like" class="btn btn-app commentMood">
                            <span class="badge bg-blue like<?=$comment['idx']?>"><?=$comment['like']?></span>
                            <i class="fa fa-heart-o"></i>
                        </a>
                        <a href="javascript:;" data-divide="dislike" class="btn btn-app commentMood">
                            <span class="badge bg-red dislike<?=$comment['idx']?>"><?=$comment['dislike']?></span>
                            <i class="fa fa-hand-o-down"></i>
                        </a>
                    </div><!-- //timeLike -->
                </li>
                <?php } ?>
            </ul><!-- //commentList -->
            <!-- 댓글 :: END -->

        </div><!-- //x_content -->
    </div><!-- //x_panel -->
</div><!-- //col-md-12 -->

<!-- 삭제 :: STR -->
<script>
$(function(){
	$(".eventDelete").click(function(){
		var idx 	= $(this).data("idx");
		var paginNo = $(this).data("pagin");
		var url 	= "/board/board/";
		
		if(idx) {
			if( confirm("삭제하시겠습니까?") ) {
				$.ajax({
					url 		: "/board/boardDelete",
					dataType 	: "json",
					type 		: "POST",
					data 		: {
									idx     : idx,
                                    table   : "t_basicTable"
					},
					success:function(data){
						alert(data);
						window.location.href = url+paginNo;
					}
				});
			}
		}
	});
});
</script>
<!-- 삭제 :: END -->

<!-- 좋아요/싫어요 :: STR -->
<script>
$(function(){
	$(".mood").click(function(){
		var idx     = $(".eventDelete").data("idx");    //고유값
		var divide  = $(this).data("divide");           // 좋아요/싫어요 구분값

        $.ajax({
            url 		: "/board/boardMood",
            dataType 	: "json",
            type 		: "POST",
            data 		: {
                            idx     : idx,
                            divide  : divide,
                            table   : "t_basicTable",
            },
            success:function(data){
                if( data["divide"] == "like" ){
                    $(".mood .like").html(data["modeNum"]);  // 좋아요
                } else {
                    $(".mood .dislike").html(data["modeNum"]);  // 싫어요
                }
                
            }
        });
	});
});
</script>
<!-- 좋아요/싫어요 :: END -->


<!-- 댓글 삭제 :: STR -->
<script>
$(function(){
	$(".commentDelete").click(function(){
		var idx = $(this).parents("li").data("idxcom");
        
		if(idx) {
			if( confirm("삭제하시겠습니까?") ) {
				$.ajax({
					url 		: "/board/boardDelete",
					dataType 	: "json",
					type 		: "POST",
					data 		: {
									idx     : idx,
                                    table   : "t_basicTableConment"
					},
					success:function(data){
						alert(data);
                        location.reload();
					}
				});
			}
		}
	});
});
</script>
<!-- 댓글 삭제 :: END -->

<!-- 댓글 수정 :: STR -->
<script>
$(function(){
	$(".commentSave").click(function(){
        var idx = $(this).parents("li").data("idxcom");
        var con = $(this).parent().nextAll(".message").data("con");

        if(idx) {
			if( confirm("수정하시겠습니까?") ) {
                $(this).removeClass("commentSave");
                $(this).after("<a href='javascript:;' onClick='commentSaveEnd("+idx+")'>수정완료</a>");

                $(this).parent().nextAll(".message").empty();
                $(this).parent().nextAll(".message").append("<textarea name='contentAdd' rows='2'>"+con+"</textarea>");
            }
        }
	});
});
</script>

<script>
function commentSaveEnd(idx) {
    var content = $('textarea[name=contentAdd]').val();

    $.ajax({
        url 		: "/board/commentSave",
        dataType 	: "json",
        type 		: "POST",
        data 		: {
                        idx     : idx,
                        content : content
        },
        success:function(data){
            location.reload();
        }
    });
};
</script>
<!-- 댓글 수정 :: END -->

<!-- 댓글 좋아요/싫어요 :: STR -->
<script>
$(function(){
	$(".commentMood").click(function(){
		var idx = $(this).parents("li").data("idxcom");
		var divide  = $(this).data("divide");           // 좋아요/싫어요 구분값

        $.ajax({
            url 		: "/board/boardMood",
            dataType 	: "json",
            type 		: "POST",
            data 		: {
                            idx     : idx,
                            divide  : divide,
                            table   : "t_basicTableConment",
            },
            success:function(data){
                if( data["divide"] == "like" ){
                    $(".commentMood .like"+data["idx"]).html(data["modeNum"]);  // 좋아요
                } else {
                    $(".commentMood .dislike"+data["idx"]).html(data["modeNum"]);  // 싫어요
                }
                
            }
        });
	});
});
</script>
<!-- 댓글 좋아요/싫어요 :: END -->

<!-- 댓글에 댓글 작성 :: STR -->
<script>
$(function(){
	$(".commentAdd").click(function(){
        var idx       = $(this).parents("li").data("idxcom");     // 댓글의 idx
        var orgno     = $(this).parents("li").data("orgno");      // 댓글의 순서 idx
        var pageNo    = $(".eventDelete").data("idx");            // 페이지의 고유 idx
        
		$(this).parents("li").after("<textarea name='commentContent' rows='2'></textarea><a href='javascript:;' onClick='commentAddEnd("+idx+","+orgno+","+pageNo+")'>저장</a>");
		$(this).remove();
	});
});
</script>

<script>
function commentAddEnd(idx, orgno, pageNo) {
    var content = $('textarea[name=commentContent]').val();
    
    $.ajax({
        url 		: "/board/commentAdd",
        dataType 	: "json",
        type 		: "POST",
        data 		: {
                        idx         : idx,
                        orgno       : orgno,
                        pageNo      : pageNo,
                        content     : content
        },
        success:function(data){
            location.reload();
        }
    });
};
</script>
<!-- 댓글에 댓글 작성 :: END -->