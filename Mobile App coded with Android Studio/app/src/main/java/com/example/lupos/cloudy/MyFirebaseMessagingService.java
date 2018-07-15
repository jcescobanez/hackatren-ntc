package com.example.lupos.cloudy;


import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.speech.tts.TextToSpeech;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.Toast;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

import java.util.Locale;

public class MyFirebaseMessagingService extends FirebaseMessagingService {

    TextToSpeech t1;
    String station_message ="";

    @Override
    public void onCreate() {
       // Toast.makeText(getApplicationContext(), "QWEQWEQW", Toast.LENGTH_SHORT).show();

        t1=new TextToSpeech(getApplicationContext(), new TextToSpeech.OnInitListener() {
            @Override
            public void onInit(int status) {
                if (status != TextToSpeech.ERROR) {
                    t1.setLanguage(Locale.ENGLISH);
                    t1.speak("You are arriving at "+station_message, TextToSpeech.QUEUE_FLUSH, null);
                }

            }
        });


    }

    @Override
    public void onNewToken(String s) {
        super.onNewToken(s);
        Log.e("TOKEN: " , s);
    }

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        station_message = remoteMessage.getData().get("message");
        showNotification(station_message);
    }

    private void showNotification(String message) {
        Intent i = new Intent(this, MainActivity.class);
        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

        PendingIntent pendingIntent = PendingIntent.getActivity(this,0,i, PendingIntent.FLAG_UPDATE_CURRENT);

        NotificationCompat.Builder builder = new NotificationCompat.Builder(this, "HelloWorld")
                .setAutoCancel(true)
                .setContentTitle("LRT 1 Alert")
                .setContentText("You are arriving at " + message)
                .setSmallIcon(R.drawable.logo2)
                .setContentIntent(pendingIntent)
                .setDefaults(Notification.DEFAULT_ALL)
                .setPriority(Notification.PRIORITY_HIGH);


        NotificationManager manager = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);

        manager.notify(2, builder.build());


    }
}
