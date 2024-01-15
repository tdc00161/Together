<div class="task_modal insert_modal" style='display: none;'>
	<div class="header task_modal_header">
		<div>
			<div class="project_color task_project_color"></div>
			<div class="project_name">Project1</div>
			<div class="vertical_line">|</div>
			<div class="insert_type">업무</div>
		</div>
		<div class="cross_icon_w" onclick="closeTaskModal(0)"></div>
	</div>
	<div class="noline">
		<div class="content noline">
			<div class="type_task">
				<div class="overheader" style="display: none">
					{{-- <div class="task_name grand_parent">> 업무1 (testTask1)</div> --}}
					<div class="task_name parent"></div>
				</div>
			</div>
			<input type="text" class="insert_title" placeholder="제목을 입력하세요.">
			<div class="property type_task">
				<div class="status">
					<div></div>
					<div id="checked" class="status_val" onclick="changeStatus(event)">시작전</div>
					<div class="status_val" onclick="changeStatus(event)">진행중</div>
					<div class="status_val" onclick="changeStatus(event)">피드백</div>
					<div class="status_val" onclick="changeStatus(event)">완료</div>
				</div>
				<div class="responsible add_box">
					<div class="responsible_icon"></div>
					<div class="responsible_one insert_responsible_one d-none">
						<div class="user_profile"></div>
						<div class="responsible_user"></div>
						<div class="cross_icon_b" onclick="removeResponsible(0)"></div>
					</div>
					<div class="add_box_mgin add_responsible" onclick="addResponsible(0)">담당자추가/변경</div>
					<div class="add_responsible_modal add_property_modal d-none">
						<div class="add_responsible_modal_one d-none" onclick="selectResponsible(event)">
							<div class="add_responsible_modal_one_icon"></div>
							<div class="add_responsible_modal_one_name">User</div>
						</div>
					</div>
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
				{{-- <div class="priority add_box">
					<div class="flag_icon"></div>
					<div class="priority_one insert_priority_one d-none">
						<div class="priority_icon insert_priority_icon"></div>
						<div class="priority_val insert_priority_val"></div>
						<div class="cross_icon_b" onclick="removePriority(0)"></div>
					</div>
					<div class="add_box_mgin add_priority" onclick="addPriority(0)">우선순위추가/변경</div>
					<div class="add_priority_modal add_property_modal d-none">
						<div class="add_priority_modal_one d-none" onclick="selectPriority(event)">
							<div class="add_priority_modal_one_icon"></div>
							<div class="add_priority_modal_one_name"></div>
						</div>
					</div>
				</div> --}}
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
		<div class="submit" onclick="">등록</div>
	</div>
</div>
<div class="behind_insert_modal" style='display: none;'></div>