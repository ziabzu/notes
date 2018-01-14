<?php
	session_start();

    require_once '../database/database.class.php';
    require_once '../database/auth.class.php';
    require_once '../database/user.class.php';
    require_once '../database/note.class.php';
    require_once '../lib/helper.class.php';

	$noteData = json_decode($_REQUEST['data'], true);
	$noteData = $noteData[0];

	$action = $noteData['action'];

	$result['status'] = false;

	switch ($action) {

		// Load notes when page loads
		case 'load':

			$note = new Note();

			$data = array();

			if (Auth::isLoggedIn() && ($res = $note->load())) {

				while ($row = $res->fetch_object()) {

					$data[] = array(
						'id' => $row->id, 
						'createdDate' => Helper::timeToString($row->created_date), 
						'userId' =>$row->user_id, 'text' => $row->text
					);

			    }

			    $status = true;
			    $description = "Loaded successfully";

			} else {

				$status = false;
				$description = "User not logged in";

			}

			$result['status'] = $status;
			$result['description'] = $description;
			$result['data'] = (array) $data;

			break;

		// Add note asynchronously
		case 'save-new':

		    $note = new Note();
		    $note->text = $noteData['text'];

			$res = $note->save();


			$result['status'] = $res['status'];
			$result['description'] = 'Saved successfully';

			$result['data']['id'] = $res['mysql_insert_id'];

			$now = new DateTime();
			$result['data']['createdDate'] = Helper::timeToString($now->format('Y-m-d H:i:s'));
			
			break;

		//Edit note asynchronously	
		case 'save-edit':

		    $note = new Note($noteData['id']);
		    $note->text = $noteData['text'];

			$res = $note->save();

			$result['status'] = $res['status'];
			$result['data']['id'] = $noteData['id'];
			$result['description'] = 'Saved successfully';

			break;

		//Delete note asynchronously	
		case 'delete':

		    $note = new Note($noteData['id']);
			$result['status'] = $note->delete();
			$result['description'] = 'Deleted successfully';
			
			break;
		
		default:
			# code...
			break;
	}


	echo json_encode((array) $result);

	die();