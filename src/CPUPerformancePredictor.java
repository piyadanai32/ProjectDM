import weka.classifiers.Classifier;
import weka.core.DenseInstance;
import weka.core.Instance;
import weka.core.Instances;
import weka.core.Attribute;

import java.io.*;
import java.util.*;

public class CPUPerformancePredictor {
    public static void main(String[] args) {
        try {
            // ใช้พาธแบบเต็มเพื่อป้องกันปัญหาไฟล์ไม่เจอ
            File file = new File("C:/Users/User-KK33/OneDrive/Desktop/ProjectDM/models/mymodel.model");

            // โหลดโมเดล Weka
            ObjectInputStream ois = new ObjectInputStream(new FileInputStream(file));
            Classifier model = (Classifier) ois.readObject();
            ois.close();

            if (args.length != 6) {
                System.out.println("กรุณาส่งค่ามาทั้ง 6 ตัว! (MYCT, MMIN, MMAX, CACH, CHMIN, CHMAX)");
                return;
            }

            // สร้าง Attributes
            ArrayList<Attribute> attributes = new ArrayList<>();
            attributes.add(new Attribute("MYCT"));
            attributes.add(new Attribute("MMIN"));
            attributes.add(new Attribute("MMAX"));
            attributes.add(new Attribute("CACH"));
            attributes.add(new Attribute("CHMIN"));
            attributes.add(new Attribute("CHMAX"));
            attributes.add(new Attribute("Performance")); // Target attribute

            // สร้าง Instances และตั้งค่า class index
            Instances data = new Instances("TestInstance", attributes, 0);
            data.setClassIndex(attributes.size() - 1);

            // รับค่าจาก arguments
            double[] values = Arrays.stream(args).mapToDouble(Double::parseDouble).toArray();

            // สร้าง Instance
            Instance instance = new DenseInstance(attributes.size());
            for (int i = 0; i < values.length; i++) {
                instance.setValue(attributes.get(i), values[i]);
            }
            instance.setMissing(attributes.get(attributes.size() - 1)); // Performance เป็นค่า target

            data.add(instance);

            // ทำนายผลลัพธ์
            double prediction = model.classifyInstance(data.instance(0));
            System.out.println(prediction); // ส่งค่าให้ PHP อ่านง่ายขึ้น

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
