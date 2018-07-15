package com.example.lupos.cloudy;

import android.content.Intent;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Stationqueue extends AppCompatActivity {

    private static final String TAG_STATION = "station";
    private static final String TAG_TIME ="time";
    ArrayList<HashMap<String, Object>> personList;
    ListView list;
    JSONArray peoples;
    private Dialog loadingDialog;
    RequestQueue queue;

    String result;

    private SwipeRefreshLayout mySwipeRefreshLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_stationqueue);



        list = (ListView) findViewById(R.id.listView);
        personList = new ArrayList<HashMap<String,Object>>();











        execute();

        mySwipeRefreshLayout = (SwipeRefreshLayout) findViewById(R.id.swiperefresh);
        mySwipeRefreshLayout.setOnRefreshListener(
                new SwipeRefreshLayout.OnRefreshListener() {
                    @Override
                    public void onRefresh() {

                        execute();

                    }
                }

        );

    }
    public void next(View v){
       finish();
    }

    public void execute(){
        queue = Volley.newRequestQueue(this);
        String url = "http://bshscare.com/Zipp/app/api/android_api/list_stations";

        StringRequest req = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                mySwipeRefreshLayout.setRefreshing(false);
               // Toast.makeText(Stationqueue.this, response, Toast.LENGTH_SHORT).show();
                try {

                    result = new JSONObject(response).getJSONArray("data").toString();
                   // Toast.makeText(Stationqueue.this, result, Toast.LENGTH_SHORT).show();
                    showList();

                    /// For Show Date
                    String currentDateString = DateFormat.getDateInstance().format(new Date());
                    // textView is the TextView view that should display it
                    /// For Show Time
                    String currentTimeString = DateFormat.getTimeInstance().format(new Date());
                    // textView is the TextView view that should display it
                    TextView date = (TextView)findViewById(R.id.date);
                    date.setText("Last Updated: 9" + currentDateString + ", "+currentTimeString);

                } catch (JSONException e) {
                    e.printStackTrace();
                }


            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                return params;
            }
        };

        req.setRetryPolicy(new DefaultRetryPolicy(
                0,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));


        queue.add(req);
    }


    protected void showList(){
        personList.clear();
        try {
            peoples = new JSONArray(result);

            for(int i=0;i<peoples.length();i++) {
                JSONObject c = peoples.getJSONObject(i);



                String station = c.getString(TAG_STATION);
                String time = c.getString(TAG_TIME);
                HashMap<String, Object> persons = new HashMap<String, Object>();
                persons.put(TAG_STATION, station);
                persons.put(TAG_TIME, time);


                personList.add(persons);


            }



            ExtendedSimpleAdapter adapter = new ExtendedSimpleAdapter(
                    Stationqueue.this, personList, R.layout.list_queue,
                    new String[]{},
                    new int[]{}
            );

            list.setAdapter(adapter);

//            list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
//                @Override
//                public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {
//
//                    try {
//
//                        JSONObject doctor_data = peoples.getJSONObject(position);
//                        name = (TextView) findViewById(R.id.json);
//                        name.setText(doctor_data.toString());
//                        Intent intent = new Intent(ikonsulta_findurdoctor.this, showdoctor.class);
//                        intent.putExtra("jsondoctor", doctor_data.toString());
//                        intent.putExtra("jsonpinfo", str);
//                        startActivity(intent);
//
//                    } catch (JSONException e) {
//                        e.printStackTrace();
//                    }
//
//
//                }
//            });


        } catch (JSONException e) {
            e.printStackTrace();
        }



    }

    public class ExtendedSimpleAdapter extends SimpleAdapter {

        private Context mContext;
        public LayoutInflater inflater=null;
        public ExtendedSimpleAdapter (Context context, List<? extends Map<String, ?>> data, int resource, String[] from, int[] to) {
            super(context, data, resource, from, to);
            mContext = context;
            inflater = (LayoutInflater)mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            View vi=convertView;
            if(convertView==null)
                vi = inflater.inflate(R.layout.list_queue, null);

            HashMap<String, Object> data = (HashMap<String, Object>) getItem(position);
            TextView station = (TextView)vi.findViewById(R.id.station);
            String station1 = (String) data.get(TAG_STATION);
            station.setText(station1);

            TextView time = (TextView)vi.findViewById(R.id.time);
            String time1 = (String)data.get(TAG_TIME);
            time.setText((String)data.get(TAG_TIME));

            ImageView circle = (ImageView)vi.findViewById(R.id.circle);

            if (time1.equals("5 Minutes")||time1.equals("10 Minutes")){
                circle.setColorFilter(Color.parseColor("#FF02A902"));

            }
            else if (time1.equals("15 Minutes")||time1.equals("20 Minutes")||time1.equals("25 Minutes")){
                circle.setColorFilter(Color.parseColor("#FFFFD500"));

            }
            else {
                circle.setColorFilter(Color.parseColor("#FFA60016"));
            }




            return vi;
        }
    }

    public void back(View view){
        finish();
    }
}
