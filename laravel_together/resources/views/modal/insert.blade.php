<div class="task_modal insert_modal" style='display: none;'>
	<div class="header">
		<div>
			<div class="project_color"></div>
			<div class="project_name">Project1</div>
			<div class="vertical_line">|</div>
			<div class="insert_type">업무</div>
		</div>
		<div class="cross_icon_w" onclick="closeTaskModal(0)"></div>
	</div>
	<div class="noline">
		<div class="content noline">
			<div class="type_task">
				<div class="overheader">
					{{-- <div class="task_name grand_parent">> 업무1 (testTask1)</div> --}}
					<div class="task_name parent">> 업무2 (testTask2)</div>
				</div>
			</div>
			<input type="text" class="insert_title" placeholder="제목을 입력하세요.">
			<div class="property type_task">
				<div class="status">
					<div></div>
					<div id="checked" class="status_val" onclick="changeStatus(0)">시작전</div>
					<div class="status_val" onclick="changeStatus(1)">진행중</div>
					<div class="status_val" onclick="changeStatus(2)">피드백</div>
					<div class="status_val" onclick="changeStatus(3)">완료</div>
				</div>
				<div class="responsible add_box">
					<div class="responsible_icon"></div>
					<div class="responsible_one" style='display: none;'>
						<div class="user_profile"></div>
						<div>User</div>
						<div class="cross_icon_b" onclick="removeResponsible(0)"></div>
					</div>
					<div class="add_box_mgin add_responsible" onclick="addResponsible(0)">담당자추가</div>
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
					<div class="flag_icon"></div>
					<div class="priority_one" style='display: none;'>
						<div class="priority_icon"></div>
						<div>보통</div>
						<div class="cross_icon_b" onclick="removePriority(0)"></div>
					</div>
					<div class="add_box_mgin add_priority" onclick="addPriority(0)">우선순위추가</div>
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
<div class="behind_insert_modal" style='display: none;'></div>