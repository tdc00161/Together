<div class="task_modal detail_modal" style='display: none;'>
	<div class="header">
		<div>
			<div class="project_color"></div>
			<div class="project_name">Project1</div>
		</div>
		<div class="cross_icon_w" onclick="closeTaskModal(1)"></div>
	</div>
	<div>
		<div class="content">
			<div class="type_task">
				<div class="overheader">
					<div class="task_name">> 업무1 (testTask1)</div>
					<div class="task_name">> 업무2 (testTask2)</div>
				</div>
			</div>
			<div class="header">
				<div>
					<div class="user_profile"></div>
					<div>User</div>
					<div>2023-12-13 11:30</div>
				</div>
				<div class="more" onclick="openMoreModal()">
					<!-- 더보기 모달 -->
					<div class="more_modal" style='display: none;'>
						<div>
							<div class="update_icon"></div>
							<div>수정</div>
						</div>
						<div>
							<div class="delete_icon"></div>
							<div>삭제</div>
						</div>
					</div>
				</div>
			</div>
			<div class="title">신라호텔에서 회식</div>
			<div class="property type_task">
				<div class="status">
					<div></div>
					<div id="checked" class="det_status_val">시작전</div>
				</div>
				<div class="responsible add_box">
					<div class="responsible_icon"></div>
					<div class="responsible_one">
						<div class="user_profile"></div>
						<div>User</div>
						<div></div>
					</div>
					{{-- <div class="add_box_mgin add_responsible">담당자변경</div> --}}
				</div>
				<div class="dead_line">
					<div></div>
					<input 
						class="start_date"
						type="text" 
						placeholder="2023-12-04"
						readonly
					>
					<p>~</p>
					<div></div>
					<input 
						class="end_date"
						type="text" 
						placeholder="2023-12-22"
						readonly
	  				>
				</div>
				<div class="priority add_box">
					<div></div>
					<div>
						<div class="priority_icon"></div>
						<div>보통</div>
						<div></div>
					</div>
					{{-- <div class="add_box_mgin">우선순위변경</div> --}}
				</div>
			</div>
			<div class="content">
				코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식코스요리 열심히 시식
				<div>댓글</div>
			</div>
		</div>
		<div class="comment">
			<div class="comment_one" style='display: none;'>
				<div class="user_profile"></div>
				<div class="comment_content">
					<div>
						<div>
							<div class="user_name">User1</div>
							<div class="comment_date">2023-12-13 14:34</div>
						</div>
						<div class="delete_comment" onclick="removeComment(0)">삭제</div>
					</div>
					<div class="comment_line">기본 댓글</div>
				</div>
			</div>
			<div class="comment_one">
				<div class="user_profile"></div>
				<div class="comment_content">
					<div>
						<div>
							<div class="user_name">User2</div>
							<div class="comment_date">2023-12-13 14:34</div>
						</div>
						<div class="delete_comment" onclick="removeComment(1)">삭제</div>
					</div>
					<div class="comment_line">이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥</div>
				</div>
			</div>
			<div class="comment_one">
				<div class="user_profile"></div>
				<div class="comment_content">
					<div>
						<div>
							<div class="user_name">User3</div>
							<div class="comment_date">2023-12-13 14:34</div>
						</div>
						<div class="delete_comment" onclick="removeComment(2)">삭제</div>
					</div>
					<div class="comment_line">이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥</div>
				</div>
			</div>
			<div class="comment_one">
				<div class="user_profile"></div>
				<div class="comment_content">
					<div>
						<div>
							<div class="user_name">User4</div>
							<div class="comment_date">2023-12-13 14:34</div>
						</div>
						<div class="delete_comment" onclick="removeComment(3)">삭제</div>
					</div>
					<div class="comment_line">이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥</div>
				</div>
			</div>
			<div class="comment_one">
				<div class="user_profile"></div>
				<div class="comment_content">
					<div>
						<div>
							<div class="user_name">User5</div>
							<div class="comment_date">2023-12-13 14:34</div>
						</div>
						<div class="delete_comment" onclick="removeComment(4)">삭제</div>
					</div>
					<div class="comment_line">이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥이거 먹을바에 국밥</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="user_profile"></div>
		<textarea 
			id="comment_input" 
			type="text" 
			placeholder="댓글 작성란"
		></textarea>
		{{-- onchange="testareaHeight()" --}}
		<div class="submit" onclick="addComment()">작성</div>
	</div>
</div>