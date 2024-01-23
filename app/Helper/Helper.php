<?php
    namespace App\Helper;

    use App\Models\ProducationLinesModel;
use App\Models\ProjectAttachmentModel;

class Helper
    {
        function updateProgressStatus($check_progress_status, $progress_status) {
            if ($check_progress_status->progress_status <= $progress_status) {
                $check_progress_status->progress_status = 1;
                $check_progress_status->save();
            }
        }

        function uploadAndSaveAttachment($request, $model){
            return 'data';
            $data = new $model;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('production', $filename, 'public');
                $data->attachment = $filename;
            }

            if ($data->save()){
                return response()->json([
                    'success' => 'true',
                    'message' => 'تم اضافة الصورة بنجاح'
                ]);
            } else {
                return response()->json([
                    'success' => 'false',
                    'message' => 'هناك خلل ما لم يتم اضافة الصورة بنجاح'
                ]);
            }        }
    }
?>
