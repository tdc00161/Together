<div class="task_modal insert_task_modal">
	<div class="header">
		<div>
			<div class="project_color"></div>
			<div class="project_name">Project1</div>
			<div class="vertical_line">|</div>
			<div class="insert_type">업무</div>
		</div>
		<div class="cross_icon_w" onclick="closeInsertModal()"></div>
	</div>
	<div class="noline">
		<div class="content noline">
			<div class="overheader type_task">
				<div class="task_name">> 업무1 (testTask1)</div>
				<div class="task_name">> 업무2 (testTask2)</div>
			</div>
			<input type="text" class="insert_title" placeholder="제목을 입력하세요.">
			<div class="property type_task">
				<div class="status">
					<div></div>
					<div id="checked" class="ins_status_val" onclick="changeInsertStatus(0)">시작전</div>
					<div class="ins_status_val" onclick="changeInsertStatus(1)">진행중</div>
					<div class="ins_status_val" onclick="changeInsertStatus(2)">피드백</div>
					<div class="ins_status_val" onclick="changeInsertStatus(3)">완료</div>
				</div>
				<div class="responsible add_box">
					<div></div>
					<div class="respon_one">
						<div class="user_profile"></div>
						<div>User</div>
						<div class="cross_icon_b"></div>
					</div>
					<div id="add_box_mgin">담당자변경</div>
				</div>
				<div class="dead_line">
					<div></div>
					<input 
						class="start_date"
						type="text" 
						placeholder="시작일"
						onfocus="(this.type='date')"
						onblur="(this.type='text')"
					>
					<p>~</p>
					<div></div>
					<input 
						class="end_date"
						type="text" 
						placeholder="마감일"
						onfocus="(this.type='date')"
      					onblur="(this.type='text')"
	  				>
				</div>
				<div class="priority add_box">
					<div></div>
					<div>
						<div class="priority_icon"></div>
						<div>보통</div>
						<div class="cross_icon_b"></div>
					</div>
					<div id="add_box_mgin">우선순위변경</div>
				</div>
			</div>
			{{-- <div class="content"> --}}
				<textarea 
					class="insert_content"
					name="" 
					id="" 
					cols="30" 
					rows="10"
					placeholder="내용을 입력하세요."
				></textarea>
			{{-- </div> --}}
		</div>
	</div>
	<div class="insert_footer">
		<div class="submit">등록</div>
	</div>
</div>