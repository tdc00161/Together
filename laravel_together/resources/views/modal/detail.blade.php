<div class="task_modal detail_modal d-none">
	<div class="header task_modal_header">
		<div class="">
			<div class="project_color task_project_color"></div>
			<div class="project_name "></div>
		</div>
		<div class="cross_icon_w" onclick="closeTaskModal(1)"></div>
	</div>
	<div>
		<div class="content">
			<div class="type_task">
				<div class="overheader" style="display: none">
					{{-- <div class="task_name grand_parent" style="display: none">> grand_parent</div> --}}
					<div class="task_name parent " style="display: none">> parent</div>
				</div>
			</div>
			<div class="header task_modal_header">
				<div class="">
					<div class="user_profile "></div>
					<div class="wri_name "></div>
					<div class="task_created_at "></div>
				</div>
				<div class="more" onclick="openMoreModal()">
					<!-- 더보기 모달 -->
					<div class="more_modal" style='display: none;'>
						<div onclick="updateModalOpen()">
							<div class="update_icon detail_update"></div>
							<div class="detail_update">수정</div>
						</div>
						<div onclick="deleteTask()">
							<div class="delete_icon detail_delete"></div>
							<div class="detail_delete">삭제</div>
						</div>
					</div>
				</div>
			</div>
			<div class="title detail_title "></div>
			<div class="property type_task d-none">
				<div class="status ">
					<div></div>
					<div id="checked" class="det_status_val">시작전</div>
				</div>
				<div class="responsible add_box ">
					<div class="responsible_icon"></div>
					<div class="responsible_one">
						<div class="user_profile"></div>
						<div class="responsible_user"></div>						
					</div>
					{{-- <div class="add_box_mgin add_responsible">담당자 추가/변경</div> --}}
				</div>
				<div class="dead_line ">
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
				{{-- <div class="priority add_box ">
					<div class="flag_icon"></div>
					<div class="priority_one">
						<div class="priority_icon"></div>
						<div class="priority_val"></div>
					</div>
					<div class="add_box_mgin">우선순위 추가/변경</div>
				</div> --}}
			</div>
			<div class="content detail_content ">
				<p class="detail_content"></p>
			</div>
			<div class="comment_start">댓글</div>
		</div>
		<div class="comment">
			<div class="comment_one">
				<div class="user_profile "></div>
				<div class="comment_content ">
					<div>
						<div>
							<div class="user_name "></div>
							<div class="comment_date "></div>
						</div>
						<div class="update_comment" onclick="updateComment(event, 0)">편집</div>
						<div class="save_comment d-none">저장</div>
						<div class="delete_comment" onclick="removeComment(event, 0);">삭제</div>
						<div class="cancel_comment d-none">취소</div>
					</div>
					<div class="comment_line "></div>
					<input type="hidden" name="id" value="">
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
		<div class="submit" onclick="addComment()">등록</div>
	</div>
</div>