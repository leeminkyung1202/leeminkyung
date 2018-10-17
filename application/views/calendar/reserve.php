<style>
    #calendar tr td{
        height: 45px;
        vertical-align: top;
    }
    .listCon{
        color: #ccc;
    }
</style>

<script>
    var today   = new Date();           // 표준 날짜 및 시간
    var year    = today.getFullYear();  // 현재 년도
    var month   = today.getMonth();     // 월(0~11)
    var day     = today.getDay();       // 한 주에 대한 요일(0~6)

    month += 1;

    // 월의 일 수를 구함.
    function dayNum(year, month) {
        switch(month) {
            case 1: case 3: case 5: case 7: case 8: case 10: case 12:
            return 31;

            case 4: case 6: case 9: case 11:
            return 30;

            case 2:
                if( (year%400)==0 || (year%4)==0 && (year%100)!=0 ) {
                    return 29;
                }
                else {
                    return 28;
                }
        }
    }

    // 이전 월로 이동
    function prevmonth() {
        var action  = document.getElementById("prev");  // 이전
        var dates   = document.getElementById("date");  // 현재 년,월

        month--;    // 월을 계속 감소 시킨다.

        // 월이 1보다 작아지면
        if( month < 1 ) {
            month = 12;     // 월을 12월로 변경
            year -= 1;      // 년도를 1년 감소
        }

        var action = year + "년" + (month)+"월";

        calendars();    // calendars() 함수를 호출해서 다시 찍어줌.
    }

    // 다음 월로 이동
    function nextmonth() {
        var action  = document.getElementById("next");  // 다음
        var dates   = document.getElementById("date");  // 현재 년,월

        month++;    // 월을 계속 증가 시킨다.

        // 월이 12보다 커지면
        if( month > 12 ) {
            month = 1;     // 월을 1월로 변경
            year += 1;     // 년도를 1년 증가
        }

        var action = year + "년" + (month)+"월";

        calendars();    // calendars() 함수를 호출해서 다시 찍어줌.
    }

    function calendars() {
        var start       = new Date(year, month-1, 1);           // 시작 요일 구하기
        var dates       = document.getElementById("date");      // 현재 년,월
        var section     = document.getElementById("calendar");  // 달력 ID

        var row = null;
        var cnt = 0;

        // 년도 보여주기
        var action = year + "년" + (month)+"월";
        dates.innerHTML = action;

        // 테이블 행의 길이가 2보다 크면 테이블 행 제거
        while( calendar.rows.length > 2 ) {
            calendar.deleteRow(calendar.rows.length -1);
        }

        row = section.insertRow();  // 행 삽입

        for( var j=0;j<start.getDay();j++ ) { // 달력의 시작 일 구함
            cell = row.insertCell();
            cnt += 1;
        }

        for( var i=0;i<dayNum(year, month);i++ ) { // 달력 일수만큼 찍어줌
            cell = row.insertCell();
            cell.innerHTML = "<span class='"+year+"-"+month+"-"+(i+1)+"' style='cursor: pointer;' onclick='memo("+year+","+month+","+(i+1)+")'>"+(i+1)+"</span>";
            cnt += 1;

            if( cnt%7 == 0 ) { // cnt가 7이면 행을 늘려줌
                row = calendar.insertRow();
            }
        }

        // 일정 리스트
        var listNum = $(".reserveList p.list").length;

        for( var num=0;num<listNum;num++ ) {
            var list = $("p.list").eq(num).data("date");
            var listCon = $("p.list").eq(num).text();

            if( $("#calendar tr td span").hasClass(list) ) {
                $("#calendar tr td span."+list).after("<p class='listCon'>"+listCon+"</p>");
            }
        }
    }
</script>

<!-- 달력 :: STR -->
<table id="calendar" style="width: 100%;">
    <colgroup>
        <col width="14%" />
        <col width="14%" />
        <col width="14%" />
        <col width="14%" />
        <col width="14%" />
        <col width="14%" />
        <col width="14%" />
    </colgroup>
    <tr style="height: 50px;">
        <td id="prev"><label onclick="prevmonth()"> < </label></td>
        <td colspan="5" id="date" style="text-align: center;"></td>
        <td id="next"><label onclick="nextmonth()"> > </label></td>
    </tr>

    <tr style="height: 50px;vertical-align: top;">
        <th>일</th>
        <th>월</th>
        <th>화</th>
        <th>수</th>
        <th>목</th>
        <th>금</th>
        <th>토</th>
    </tr>
</table><!-- //calendar -->
<!-- 달력 :: END -->

<!-- 일정 등록 :: STR -->
<div class="reserve" style="display: none;">
    <input type="text" name="content" />
    <button type="button" class="btn btn-default" id="reserveSave">저장</button>
</div><!-- //reserve -->
<!-- 일정 등록 :: END -->

<!-- 일정 목록 :: STR -->
<div class="reserveList" style="display: none;">
<?php foreach( $list as $list ) { ?>
    <p class="list" data-date="<?=$list['dateReserve']?>"><?=$list['content']?></p>
<?php } ?>
</div><!-- //reserveList -->
<!-- 일정 목록 :: END -->
<script>
    calendars();
</script>

<script>
    // 현재 날짜 하이라이트
    $(function(){
        var now = new Date();         // 표준 날짜 및 시간
        var y   = now.getFullYear();  // 현재 년도
        var m   = now.getMonth()+1;   // 월(0~11)
        var d   = now.getDate();       // 일

        var ymd = y+"-"+m+"-"+d;

        if( $("#calendar tr td span").hasClass(ymd) ) {
            $("#calendar tr td span."+ymd).css("color", "red");
        }

    });

    // 일정 등록
    function memo(y,m,d){
        $(".reserve").css("display", "block");

        $("#reserveSave").click(function(){
            var content = $("input[name='content']").val();     // 내용
            var reserve = y+"-"+m+"-"+d;                       // 등록 될 날짜

            $.ajax({
                url 		: "/calendar/reserve",
                dataType 	: "json",
                type 		: "POST",
                data 		: {
                    content : content,
                    reserve : reserve
                },
                success:function(data){
                    alert(data);
                    location.reload();
                }
            });
        });
    }
</script>
